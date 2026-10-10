<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PembayaranExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class LaporanPembayaranController extends Controller
{
    public function hari()
    {
     return view('laporan.pembayaran.harian');
    }
    
    // Data laporan harian melalui AJAX
    public function LaporanHarian(Request $request)
    {
        $request->validate([
            'tanggal_awal' => ['required', 'date'],
            'tanggal_akhir' => [
                'required',
                'date',
                'after_or_equal:tanggal_awal',
            ],
        ]);

        $data = DB::table('pembayaran')
            ->whereDate('tanggal', '>=', $request->tanggal_awal)
            ->whereDate('tanggal', '<=', $request->tanggal_akhir)
            ->orderBy('tanggal', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'data' => $data,
            'total_jumlah' => $data->sum('jumlah'),
            'total_pembayaran' => $data->sum('total'),
        ]);
    }





}
