<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PembayaranExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;


class LaporanPembayaranController extends Controller
{
    public function hari()
    {
     return view('laporan.pembayaran.harian');
    }
}
