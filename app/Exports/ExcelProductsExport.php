<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ExcelProductsExport implements FromQuery, WithHeadings, WithMapping, WithChunkReading, ShouldQueue
{
    use Exportable;

    // Số lượng bản ghi xử lý mỗi lần 
    protected $chunkSize;

    // Khởi tạo với chunk size
    public function __construct($chunkSize)
    {
        $this->chunkSize = $chunkSize;
    }

    // Query lấy dữ liệu từ bảng products với cursor để tối ưu memory
    public function query()
    {
        return Product::query()->with('category')->select([
            'id',
            'name',
            'sku',
            'stock',
            'category_id',
            'expired_at',
            'created_at',
            'updated_at',
        ]);
    }
    //Heading cho file excel
    public function headings(): array
    {
        return [
            'ID',
            'Tên sản phẩm',
            'SKU',
            'Số lượng',
            'Danh mục',
            'Ngày hết hạn',
            'Ngày tạo',
            'Ngày cập nhật'
        ];
    }

    // Map data cho từng dòng
    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->sku,
            $product->stock,
            $product->category?->name,
            $product->expired_at?->format('d/m/Y'),
            $product->created_at->format('d/m/Y'),
            $product->updated_at->format('d/m/Y')
        ];
    }

    // Kích thước chunk khi đọc data
    public function chunkSize(): int
    {
        return $this->chunkSize;
    }
}
