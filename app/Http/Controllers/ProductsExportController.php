<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Exports\ProductQueueExport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel as ExcelFormat;

class ProductsExportController extends Controller
{
    /**
     * Endpoint export sản phẩm với định dạng tùy chọn (xlsx, csv, pdf).
     * Ví dụ: /exports?format=pdf
     */
    public function exports(Request $request)
    {
        // Lấy định dạng từ query parameter 'format', mặc định là 'xlsx'
        $format = $request->input('format', 'xlsx');
        switch (strtolower($format)) {
            case 'csv':
                $writerType = ExcelFormat::CSV;
                $fileName = 'exports/products-csv.csv';
                break;
                // case 'pdf':
                //     $writerType = ExcelFormat::MPDF;
                //     $fileName = 'exports/products-custom-queue-map-heading.pdf';
                //     break;
            default:
                $writerType = ExcelFormat::XLSX;
                $fileName = 'exports/products-excel.xlsx';
                break;
        }

        // Khởi tạo export và gán writerType theo định dạng mong muốn
        $export = new ProductQueueExport();
        $export->writerType = $writerType;

        // Sử dụng phương thức queue() để export theo queue, chỉ định fileName và queue custom nếu cần
        $export->queue($fileName, 'public')
            ->onQueue('export-products');

        // Trả về download URL để client biết file sẽ được tải về sau khi sẵn sàng.
        // Bạn có thể dùng polling hoặc websocket để phát hiện khi file sẵn sàng.
        // $downloadUrl = route('export.download', ['file' => $fileName]);
        // Tạo URL download file export, ví dụ: /admin/products/export/download?file=exports/products.xlsx
        $downloadUrl = route(getRouteName('products.export.download'), ['file' => $fileName]);

        return response()->json([
            'status'  => true,
            'message' => "Export đã được đưa vào queue với định dạng {$format}. Bạn sẽ nhận thông báo khi hoàn thành.",
            "download_url" => $downloadUrl
        ]);
    }


    /**
     * Endpoint download file export.
     * Sau khi download xong, file sẽ bị xoá khỏi storage.
     *
     * Ví dụ: /download-export?file=exports/products.xlsx
     * Ví dụ: /download-export?file=exports/products-custom-queue-map-heading.xlsx
     */
    public function downloadExport(Request $request)
    {
        $fileName = $request->query('file');

        // Kiểm tra file có tồn tại trên disk public không
        if (!$fileName || !Storage::disk('public')->exists($fileName)) {
            return response()->json(['error' => 'File chưa sẵn sàng hoặc không tồn tại'], 404);
        }

        // Lấy đường dẫn đầy đủ của file từ disk public
        $filePath = storage_path('app/public/' . $fileName);


        // Stream download file và xoá file sau khi download
        return response()->streamDownload(function () use ($filePath, $fileName) {
            readfile($filePath);
            // Xoá file sau khi download từ disk public
            Storage::disk('public')->delete($fileName);
        }, basename($fileName));
    }
}
