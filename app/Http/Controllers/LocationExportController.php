<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\LocationExport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel as ExcelFormat;

class LocationExportController extends Controller
{
    //

    public function export(Request $request)
    {

        // Lấy định dạng từ query parameter 'format', mặc định là 'xlsx'
        $format = $request->input('format', 'xlsx');
        switch (strtolower($format)) {
            case 'csv':
                $writerType = ExcelFormat::CSV;
                $fileName = 'exports/location-csv.csv';
                break;
                // case 'pdf':
                //     $writerType = ExcelFormat::MPDF;
                //     $fileName = 'exports/products-custom-queue-map-heading.pdf';
                //     break;
            default:
                $writerType = ExcelFormat::XLSX;
                $fileName = 'exports/location-excel.xlsx';
                break;
        }

        // Khởi tạo export và gán writerType theo định dạng mong muốn
        $export = new LocationExport();
        $export->writerType = $writerType;

        // Sử dụng phương thức queue() để export theo queue, chỉ định fileName và queue custom nếu cần
        $export->queue($fileName, 'public')
            ->allOnQueue('export-locations');

        // Trả về download URL để client biết file sẽ được tải về sau khi sẵn sàng.

        // $downloadUrl = route('export.download', ['file' => $fileName]);
        // Tạo URL download file export, ví dụ: /admin/products/export/download?file=exports/products.xlsx
        $downloadUrl = route('location.export.download', ['file' => $fileName]);

        return response()->json([
            'status'  => true,
            'message' => "Export đã được đưa vào queue với định dạng {$format}. Bạn sẽ nhận thông báo khi hoàn thành.",
            "download_url" => $downloadUrl
        ]);
    }

    public function download(Request $request)
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
