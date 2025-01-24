<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Services\DeleteService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;

class ProductCategoryController extends Controller
{
    protected $deleteService;

    public function __construct(DeleteService $deleteService)
    {
        $this->deleteService = $deleteService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productCategories = ProductCategory::latest('id')->paginate(15);
        Debugbar::info('Product Categories List:');
        Debugbar::info($productCategories->items());
        return view('admin.ProductCategories.index', compact('productCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::all();
        Debugbar::info('Access Create Product Category Form');
        return view('admin.ProductCategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            // $data = $request->all();
            Debugbar::info('Request Data:');
            Debugbar::info($data);

            Debugbar::info('Data before create:');
            Debugbar::info($data);
            DB::enableQueryLog();
            ProductCategory::create($data);

            Debugbar::info('Query Log:');
            Debugbar::info(DB::getQueryLog());

            return redirect()->route('categories.index')
                ->with('success', 'Thêm danh mục thành công');
        } catch (\Throwable $e) {
            Debugbar::error('Store Product Category Error:');
            Debugbar::error($e->getMessage());
            // throw $e;
            return back()->withInput()
                ->with('error', 'Thêm danh mục thất bại');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $category)
    {
        $categories = ProductCategory::where('id', '!=', $category->id)->get();
        Debugbar::info($category->toArray());
        return view('admin.productCategories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, ProductCategory $category)
    {
        try {
            $data = $request->validated();
            Debugbar::info('Request Data:');
            Debugbar::info($data);
    
            if (!empty($data)) {
                Debugbar::info('Data before update:');
                Debugbar::info($data);
                DB::enableQueryLog();
                $category->update($data);
                Debugbar::info('Query Log:');
                Debugbar::info(DB::getQueryLog());
                return back()->with('success', 'Cập nhật thành công');
            }
    
            return back()->with('info', 'Không có thông tin nào được thay đổi');
    
        } catch (\Throwable $e) {
            Debugbar::error('Update Product Category Error:');
            Debugbar::error($e->getMessage());
            // throw $e;
            return back()->withInput()
                ->with('error', 'Cập nhật thất bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $category)
    {
        try {
            Debugbar::info('Delete Product Category:');
            Debugbar::info($category->toArray());
            // $category->delete();
            $this->deleteService->deleteCategory($category);
            
            return response()->json([
                'success' => true,
                'message' => 'Xóa danh mục thành công'
            ]);
        } catch (\Throwable $e) {
            Debugbar::error('Delete Product Category Error:');
            Debugbar::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Xóa danh mục thất bại'
            ]);
        }
    }
}
