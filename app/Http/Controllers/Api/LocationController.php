<?php

namespace App\Http\Controllers\Api;

use App\Models\Province;
use App\Models\District;
use App\Models\Commune;
use App\Http\Controllers\Controller;
use App\Services\LocationService;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $locationService;

    // Chạy worker riêng : php artisan queue:work --queue=location_import
    /**
     * Khởi tạo controller với service
     */
    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    /**
     * Lấy danh sách tỉnh/thành phố
     */
    public function getProvinces()
    {
        $provinces = $this->locationService->getProvinces();
        return response()->json([
            'success' => true,
            'data' => $provinces
        ]);
    }

    /**
     * Lấy danh sách quận/huyện theo tỉnh
     */
    public function getDistricts($provinceId)
    {
        $districts = $this->locationService->getDistrictsByProvince($provinceId);
        return response()->json([
            'success' => true,
            'data' => $districts
        ]);
    }

    /**
     * Lấy danh sách xã/phường theo quận/huyện
     */
    public function getCommunes($districtId)
    {
        $communes = $this->locationService->getCommunesByDistrict($districtId);
        return response()->json([
            'success' => true,
            'data' => $communes
        ]);
    }

    /**
     * Tìm kiếm địa chỉ theo từ khoá
     */
    public function search(Request $request)
    {
        $keyword = $request->get('q');
        $type = $request->get('type', 'province');

        switch($type) {
            case 'province':
                $results = Province::where('name', 'LIKE', "%{$keyword}%")
                    ->limit(10)
                    ->get();
                break;
            case 'district':
                $results = District::where('name', 'LIKE', "%{$keyword}%")
                    ->limit(10)
                    ->get();
                break;
            case 'commune':
                $results = Commune::where('name', 'LIKE', "%{$keyword}%")
                    ->limit(10)
                    ->get();
                break;
        }

        return response()->json([
            'success' => true,
            'data' => $results
        ]);
    }
    
}