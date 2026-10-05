<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
    'kode_pembayaran',
    'tanggal',
    'nim',
    'nama',
    'kelas',
    'jenis_pembayaran',
    'status',
    'bulan',
    'jumlah',
    'total',
    'keterangan',
    ];

    //opsional: casting tipe data agar otomatis di konversi saat di akses
    protected $casts = [
        'jumlah' => 'integer',
        'tanggal' => 'date',
        'total' => 'decimal:2',
    ];
    
}
