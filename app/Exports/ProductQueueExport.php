<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Excel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductQueueExport implements FromQuery, WithMapping, WithHeadings, ShouldQueue, WithCustomCsvSettings, ShouldAutoSize
{
    use Exportable;

    // Property để xác định writer type, mặc định là XLSX
    public $writerType = Excel::XLSX;

    public function query()
    {


        return Product::query()
            ->with('category:id,name') // Eager load quan hệ category
            ->withSum('orderDetails as total_sold', 'quantity'); // Tính tổng số lượng đã bán từ orderDetails
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->sku,
            $product->name,
            optional($product->category)->name ?? 'Chưa có danh mục',
            $product->price,
            $product->stock,
            $product->total_sold,
            $product->created_at->format('d/m/Y'),
            $product->updated_at->format('d/m/Y'),
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'SKU',
            'Tên sản phẩm',
            'Danh mục',
            'Giá',
            'Tồn kho',
            'Tổng số lượng đã bán',
            'Ngày tạo',
            'Ngày cập nhật'
        ];
    }

    /**
     * Thêm BOM, dấu phân cách, v.v.
     */
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ',',
            'enclosure' => '"',
            'line_ending' => "\r\n",
            'use_bom' => true, // quan trọng: thêm BOM
        ];
    }
}
