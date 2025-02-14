<?php

namespace App\Http\Controllers\Api\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Format response chuẩn cho API
     */
    private function responseJson($success, $message = '', $data = [], $code = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Danh Sách sản phẩm 1 trang 10 sản phẩm
     *  
     */
    public function index (Request $request)
    {
        $products = Product::paginate(10);
        return $this->responseJson(true, 'Danh sách sản phẩm', $products);
    }

    /**
     * Chi tiết sản phẩm
     */
    public function show (Product $product)
    {
        // $product = Product::find($product->id);

        if (!$product) {
            return $this->responseJson(false, 'Sản phẩm không tồn tại', [], 404);
        }
        return $this->responseJson(true, 'Chi tiết sản phẩm', $product);
    }
}
