<?php

namespace App\Exports;

use App\pembayaran;

class PembayaranExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return pembayaran::all();
    }

public function headings(): array
{
    return['id','kode pembayaran','tanggal','nim','nama','kelas','jenis pembayaran','status','bulan','jumlah','total','keterangan','dibuat','diubah'];
} 

}