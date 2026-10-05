<?php

namespace App\Exports;

use App\siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SiswaExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return siswa::all();
    }

public function headings(): array
{
    return['dibuat','diubah','nama','nomor_induk','alamat','foto','ttl'];
} 



}