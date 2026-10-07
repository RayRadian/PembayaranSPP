<?php

namespace App\Exports;

use App\kelas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KelasExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return kelas::all();
    }

public function headings(): array
{
    return['id','nomor induk','nama','kelas','tahun ajaran','pembayaran','dibuat','diubah'];
} 



}