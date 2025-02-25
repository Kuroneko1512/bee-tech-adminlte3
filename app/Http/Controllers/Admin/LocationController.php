<?php

namespace App\Http\Controllers\Admin;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Services\LocationImportService;
use App\Http\Requests\Admin\LocationImportRequest;

class LocationController extends Controller
{
    protected $importService;

    /**
     * Khởi tạo controller với dependency injection
     * @param LocationImportService $importService Service xử lý import
     */
    public function __construct(LocationImportService $importService)
    {
        $this->importService = $importService;
    }

    /**
     * Hiển thị danh sách địa chỉ đã import
     */
    public function index()
    {
        $provinces = Province::withCount(['districts', 'communes'])->paginate(20);
        return view('admin.locations.index', compact('provinces'));
    }

    public function list()
    {
        $perPage = request('per_page', 1);
        $provinces = Province::with(['districts', 'communes'])->paginate($perPage);
        return view('admin.locations.list-export', compact('provinces'));
    }

    /**
     * Import dữ liệu từ file CSV
     * @param LocationImportRequest $request Yêu cầu chứa files import
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(LocationImportRequest $request)
    {
        try {
            $this->importService->import($request->allFiles());
            return redirect()->back()->with('success', 'Bắt đầu import dữ liệu thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Kiểm tra tiến độ import
     */
    public function importProgress()
    {
        // Lấy tổng số jobs từ cache
        $totalJobs = Cache::get('total_location_jobs', 0);

        // Đếm jobs đang chờ
        $pendingJobs = DB::table('jobs')
            ->where('queue', 'location_import')
            ->count();

        // Đếm jobs lỗi  
        $failedJobs = DB::table('failed_jobs')
            ->where('queue', 'location_import')
            ->count();

        // Lấy số jobs đã xử lý
        $processedJobs = Cache::get('processed_location_jobs', 0);

        return response()->json([
            'total' => $totalJobs,
            'pending' => $pendingJobs,
            'failed' => $failedJobs,
            'processed' => $processedJobs,
            'percent' => $totalJobs > 0 ?
                round(($processedJobs / $totalJobs) * 100) : 0,
            'error' => Cache::get('import_error')
        ]);
    }
}
