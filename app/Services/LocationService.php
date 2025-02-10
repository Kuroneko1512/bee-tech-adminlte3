<?php

namespace App\Services;

use App\Models\Province;
use App\Models\District;
use App\Models\Commune;

class LocationService
{
    /**
     * Lấy danh sách tất cả tỉnh/thành phố
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getProvinces()
    {
        return Province::orderBy('name')->get();
    }

    /**
     * Lấy danh sách quận/huyện theo tỉnh
     * @param int $provinceId ID của tỉnh/thành phố
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDistrictsByProvince($provinceId)
    {
        return District::where('province_id', $provinceId)
            ->orderBy('name')
            ->get();
    }

    /**
     * Lấy danh sách xã/phường theo quận/huyện
     * @param int $districtId ID của quận/huyện
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCommunesByDistrict($districtId)
    {
        return Commune::where('district_id', $districtId)
            ->orderBy('name')
            ->get();
    }
}
