<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PdfProductsExport implements FromQuery, WithHeadings, WithMapping
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     //
    // }

    public function query()
    {
        //
    }

    public function map($row): array
    {
        return [];
    }

    public function headings(): array
    {
        return[];
    }
}
