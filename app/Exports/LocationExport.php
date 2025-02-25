<?php

namespace App\Exports;

use App\Models\Province;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LocationExport implements FromQuery, WithMapping, WithHeadings, ShouldQueue, WithCustomCsvSettings, ShouldAutoSize
{
    use Exportable;

    // Định dạng mặc định là XLSX
    public $writerType = Excel::XLSX;

    /**
     * Query lấy dữ liệu với eager loading
     */
    public function query()
    {
        return Province::query()
            ->select('provinces.id', 'provinces.code', 'provinces.name', 'provinces.type')
            ->with([
                'districts' => function ($query) {
                    $query->select('districts.id', 'districts.code', 'districts.name', 'districts.type', 'districts.province_id');
                },
                'communes' => function ($query) {
                    $query->select('communes.id', 'communes.code', 'communes.name', 'communes.type', 'communes.district_id');
                }
            ]);
    }

    /**
     * Map dữ liệu theo định dạng xuất
     */
    public function map($province): array
    {
        $rows = [];
        foreach ($province->districts as $district) {
            foreach ($district->communes as $commune) {
                $rows[] = [
                    $province->code,
                    $province->type . ' ' . $province->name,
                    $district->code,
                    $district->type . ' ' . $district->name,
                    $commune->code,
                    $commune->type . ' ' . $commune->name
                ];
            }
        }
        return $rows;
    }

    /**
     * Tiêu đề các cột
     */
    public function headings(): array
    {
        return [
            'Mã Tỉnh/Thành phố',
            'Tên Tỉnh/Thành phố',
            'Mã Quận/Huyện',
            'Tên Quận/Huyện',
            'Mã Phường/Xã',
            'Tên Phường/Xã'
        ];
    }

    /**
     * Cấu hình cho CSV
     */
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ',',
            'enclosure' => '"',
            'line_ending' => "\r\n",
            'use_bom' => true, // Hỗ trợ Unicode
        ];
    }
}
