<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteService
{
    public function deleteCategory(ProductCategory $category)
    {
        try {
            DB::beginTransaction();
            
            // Cập nhật category_id = null cho các sản phẩm thuộc danh mục
            Product::where('category_id', $category->id)
                ->update(['category_id' => null]);
            
            // Cập nhật parent_id = null cho các danh mục con thuộc danh mục
            ProductCategory::where('parent_id', $category->id)
                ->update(['parent_id' => null]);

            // Xóa danh mục
            $category->delete();
            
            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteProduct(Product $product) 
    {
        try {
            DB::beginTransaction();
            
            // Xóa file ảnh nếu có
            if ($product->avatar) {
                Storage::delete($product->avatar);
            }
            
            // Xóa sản phẩm
            $product->delete();
            
            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
