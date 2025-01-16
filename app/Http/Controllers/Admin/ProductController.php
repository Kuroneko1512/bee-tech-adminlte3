<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Traits\UploadFileTrait;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use UploadFileTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest('id')->paginate(15);
        Debugbar::info('Products List:');
        Debugbar::info($products->items());
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::all();
        Debugbar::info('Access Create Product Form');
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $data = $request->validated();
            Debugbar::info('Request Data:');
            Debugbar::info($data);

            $data['avatar'] = $this->handleUploadFile($request, 'avatar', 'products');

            DB::enableQueryLog();
            Product::create($data);
            Debugbar::info('Query Log:');
            Debugbar::info(DB::getQueryLog());

            return redirect()->route('products.index')
                ->with('success', 'Thêm sản phẩm thành công');
        } catch (\Throwable $e) {
            Debugbar::error('Create Product Error:');
            Debugbar::error($e->getMessage());
            throw $e;
            // return back()->withInput()
            //     ->with('error', 'Thêm sản phẩm thất bại');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::all();
        Debugbar::info('Access Edit Product Form');
        Debugbar::info($product->toArray());
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $data = $request->all();

            Debugbar::info('Request Data:');
            Debugbar::info($data);
            
            // So sánh và chỉ giữ lại các trường có thay đổi
            foreach($data as $key => $value) {
                if($value === $product->$key) {
                    unset($data[$key]);
                }
            }

            // Xử lý riêng cho avatar
            if ($request->hasFile('avatar')) {
                $data['avatar'] = $this->handleUploadFile($request, 'avatar', 'products', $product->avatar);
            } else {
                unset($data['avatar']);
            }

            Debugbar::info('Changed Data:');
            Debugbar::info($data);
            
            if (!empty($data)) {                
                DB::enableQueryLog();

                $product->update($data);

                Debugbar::info('Query Log:');
                Debugbar::info(DB::getQueryLog());

                return back()->with('success', 'Cập nhật thành công');
            }

            return back()->with('info', 'Không có thông tin nào được thay đổi');

        } catch (\Throwable $e) {
            Debugbar::error('Update Product Error:');
            Debugbar::error($e->getMessage());
            // throw $e;
            return back()->withInput()
                ->with('error', 'Cập nhật thất bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            Debugbar::info('Delete Product:');
            Debugbar::info($product->toArray());
            
            if ($product->avatar) {
                Storage::delete($product->avatar);
                Debugbar::info('Delete Product Avatar:');
                Debugbar::info($product->avatar);
            }
            
            $product->delete();
            Debugbar::info('Product Deleted Successfully');
            
            return response()->json([
                'success' => true,
                'message' => 'Xóa sản phẩm thành công'
            ]);
        } catch (\Throwable $e) {
            Debugbar::error('Delete Product Error:');
            Debugbar::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Xóa sản phẩm thất bại'
            ]);
        }
    }
}
