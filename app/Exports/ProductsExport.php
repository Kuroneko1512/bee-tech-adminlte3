<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    protected $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // return Product::all(); trả về tất cả các trường dữ liệu
        return $this->products->map(function ($product) {
            return [
                'ID'            => $product->id,
                'Name'          => $product->name,
                'SKU'           => $product->sku,
                'Stock'         => $product->stock,
                'Category'      => optional($product->category)->name, // Xử lý null
                'Expiry Date'   => optional($product->expired_at)->format('d/m/Y'), 
                'Created At'    => $product->created_at->format('d/m/Y'),
                'Updated At'    => $product->updated_at->format('d/m/Y'),
            ];
        });
    }

    public function headings(): array
    {
        return ["ID", "Name",'SKU', "Stock", "Category", "Expiry Date", "Created At", "Updated At"];
    }
}
