<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Thêm giá tiền cho sản phẩm 
        // Lấy tất cả các sản phẩm từ bảng products
        $products = Product::all();

        // Duyệt qua từng sản phẩm và cập nhật giá ngẫu nhiên cho mỗi sản phẩm
        foreach ($products as $product) {
            // Sinh giá ngẫu nhiên trong khoảng từ 100000 đến 1000000
            $randomPrice = rand(100000, 1000000);
            // Cập nhật giá cho sản phẩm
            $product->update(['price' => $randomPrice]);
        }
    }
}
