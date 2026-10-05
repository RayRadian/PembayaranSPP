<?php

namespace App\Http\Controllers;

use App\pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PembayaranController extends Controller
{
    public function index(Request $request){
 
    $search = $request->search;
    $data = Pembayaran::when($search, function($query, $search){
            return $query->where('nama', 'like', "%{$search}%")
                         ->orWhere('nim', 'like', "%{$search}%");
    })
    ->orderBy('nim', 'desc')
    ->paginate(10)
    ->withQueryString();

    if ($search && $data->isEmpty()) {
     return redirect()->back()->with('error', 'Data Pembayaran tidak ditemukan');
    }


    return view('pembayaran.index', compact('data'));
    
    }

    public function create() {
    //ambil tanggal hari ini
    $today = Carbon::today();
    $prefix = 'P' . $today->format('Ymd'); //contoh: P20260922

    //cari transaksi terakhir dengan prefix tanggal hari ini
    $lastTransaction = Pembayaran::where ('kode_pembayaran', 'LIKE', $prefix . '%')
    ->orderBy('kode_pembayaran', 'desc')
    ->first();

    if ($lastTransaction) {
        $lastNumber = (int) substr($lastTransaction->kode_pembayaran, -3);
        $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    }else{
        $nextNumber = '001';
    }

    //gabungkan menjadi kode otomatis
    $kodeOtomatis = $prefix . $nextNumber; //Hasil : P20220922001


    return view('pembayaran/create', compact('kodeOtomatis'));

    }

    public function store(Request $request){
    //hitung total otomatis di server jika request 'total' kosong 
    $totalHitung = array_sum($request->input('jumlah', []));
    $request->merge(['total' => $totalHitung]);
    
    
    // 1. Validasi Input
        $request->validate([
            'tanggal'     => 'required|date',
            'nomor_induk'         => 'required|string',
            'nama'        => 'required|string',
            'kelas'       => 'required|string',
            'jenis'       => 'required|array',
            'jenis.*'       => 'required|string',
            'status'      => 'required|array',
            'status.*'      => 'required|string',
            'bulan'       => 'required|array',
            'bulan.*'       => 'required|string',
            'jumlah'      => 'required|array',
            'jumlah.*'      => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        try {
            // 2. Jalankan Database Transaction
                $kodeOtomatis = DB::transaction(function () use ($request, $totalHitung) {
                $tanggalInput = Carbon::parse($request->tanggal);
                $prefix = 'P' . $tanggalInput->format('Ymd');

                // Kunci baris saat mencari kode terakhir (Pessimistic Locking)
                // Request lain harus menunggu sampai transaksi ini selesai (commit)
                $lastTransaction = Pembayaran::where('kode_pembayaran', 'LIKE', $prefix . '%')
                    ->orderBy('kode_pembayaran', 'desc')
                    ->lockForUpdate()
                    ->first();

                if ($lastTransaction) {
                    $lastNumber = (int) substr($lastTransaction->kode_pembayaran, -3);
                    $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
                } else {
                    $nextNumber = '001';
                }

                $kode = $prefix . $nextNumber;

                // Simpan data
                foreach ($request->jenis as $index => $jenisvalue) {
                Pembayaran::create([
                    'kode_pembayaran' => $kode,
                    'tanggal'     => $request->tanggal,
                    'nim' => $request->nomor_induk,
                    'nama'        => $request->nama,
                    'kelas'       => $request->kelas,
                    'jenis_pembayaran' => $jenisvalue,
                    'status'      => $request->status[$index],
                    'bulan'       => $request->bulan[$index],
                    'jumlah'      => $request->jumlah[$index],
                    'total'       => $totalHitung,
                    'keterangan'  => $request->keterangan,
                ]);
                }
                return $kode;
            });

            return redirect()->back()->with('success', 'Data pembayaran berhasil disimpan dengan kode: ' . $kodeOtomatis);

        } catch (\Exception $e) {
            // Jika ada error/kegagalan, transaksi otomatis dibatalkan (rollback)
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function edit($kode_pembayaran)
    {
    $transaksi = Pembayaran::where('kode_pembayaran', $kode_pembayaran)
          ->orderBy('id', 'asc')
          ->get();
    if ($transaksi->isEmpty()){
        abort(404);
    }
    $data = $transaksi->first();
    return view('pembayaran.edit', compact('data', 'transaksi'));
    } 

    public function update(Request $request, $kode_pembayaran)
    {
        //dd($kode_pembayaran, $request->all());
    $request->validate([
        'id' => 'nullable|array',
        'id.*' => 'nullable|integer',
        'nomor_induk' => 'required',
        'tanggal' => 'required|date',
        'nama' => 'required',
        'kelas' => 'required',
        'jenis' => 'required|array',
        'jenis.*' => 'required',
        'status' => 'required|array',
        'status.*' => 'required',
        'bulan' => 'required|array',
        'bulan.*' => 'required',
        'jumlah' => 'required|array',
        'jumlah.*' => 'required|numeric',
    ],[
        'nomor_induk.required' => 'nim wajib diisi',
        'tanggal.required' => 'tanggal wajib diisi',
        'nama.required' => 'nama wajib disi',
        'kelas.required' => 'kelas wajib disi',
        'jenis.required' => 'jenis pembayaran wajib diisi',
        'jumlah.required' => 'jumlah wajib diisi',
        'status.required' => 'status wajib diisi',
        'bulan.required' => 'bulan wajib diisi',
        'jumlah.numeric' => 'Jumlah harus berupa angka',
    ]);

     try {

        DB::transaction(function () use ($request, $kode_pembayaran) {

            /*
            |--------------------------------------------------------------------------
            | AMBIL ID TRANSAKSI YANG MASIH ADA DI FORM
            |--------------------------------------------------------------------------
            */

            // $idYangDipertahankan = collect($request->id ?? [])
            //     ->filter()
            //     ->map(fn ($id) => (int) $id)
            //     ->values()
            //     ->toArray();

            $idYangDipertahankan = [];


            /*
            |--------------------------------------------------------------------------
            | UPDATE / TAMBAH TRANSAKSI
            |--------------------------------------------------------------------------
            */

            foreach ($request->jenis as $index => $jenis) {

                $id = $request->id[$index] ?? null;

                /*
                |--------------------------------------------------------------------------
                | TRANSAKSI LAMA
                |--------------------------------------------------------------------------
                */

                if (!empty($id)) {

                    $transaksi = Pembayaran::where('id', $id)
                        ->where('kode_pembayaran', $kode_pembayaran)
                        ->first();

                    if (!$transaksi) {
                        throw new \Exception(
                            'Data transaksi dengan ID ' . $id . ' tidak ditemukan.'
                        );
                    }

                    $transaksi->update([
                        'tanggal' => $request->tanggal,
                        'nim' => $request->nomor_induk,
                        'nama' => $request->nama,
                        'kelas' => $request->kelas,
                        'jenis_pembayaran' => $jenis,
                        'status' => $request->status[$index],
                        'bulan' => $request->bulan[$index],
                        'jumlah' => $request->jumlah[$index],
                        'keterangan' => $request->keterangan,
                    ]);
                    //simpan id lama
                    $idYangDipertahankan[] = $transaksi->id;
                }

                /*
                |--------------------------------------------------------------------------
                | TRANSAKSI BARU
                |--------------------------------------------------------------------------
                */

                else {
                    //berikan nilai total sementara
                    //akan dihitung ulang
                    $transaksi = Pembayaran::create([
                        'kode_pembayaran' => $kode_pembayaran,
                        'tanggal' => $request->tanggal,
                        'nim' => $request->nomor_induk,
                        'nama' => $request->nama,
                        'kelas' => $request->kelas,
                        'jenis_pembayaran' => $jenis,
                        'status' => $request->status[$index],
                        'bulan' => $request->bulan[$index],
                        'jumlah' => $request->jumlah[$index],
                        'total' => 0,
                        'keterangan' => $request->keterangan,
                    ]);
                    // id baru juga disimpan
                    $idYangDipertahankan[] = $transaksi->id; 
                }
            }


            /*
            |--------------------------------------------------------------------------
            | HAPUS TRANSAKSI YANG DIHAPUS DARI FORM
            |--------------------------------------------------------------------------
            */

            Pembayaran::where('kode_pembayaran', $kode_pembayaran)
                ->whereNotIn('id', $idYangDipertahankan)
                ->delete();


            /*
            |--------------------------------------------------------------------------
            | HITUNG TOTAL TERBARU
            |--------------------------------------------------------------------------
            */

            $total = Pembayaran::where('kode_pembayaran', $kode_pembayaran)
                ->sum('jumlah');


            /*
            |--------------------------------------------------------------------------
            | SIMPAN TOTAL KE SEMUA BARIS TRANSAKSI
            |--------------------------------------------------------------------------
            */

            Pembayaran::where('kode_pembayaran', $kode_pembayaran)
                ->update([
                    'total' => $total,
                ]);

        //      // DEBUG
        //      dd([   
        //      'request_id' => $request->id,
        //     'id_dipertahankan' => $idYangDipertahankan,
        //     'jenis' => $request->jenis,
        //     'status' => $request->status,
        //     'bulan' => $request->bulan,
        //     'jumlah' => $request->jumlah,
        //     'database' => Pembayaran::where(
        //         'kode_pembayaran',
        //         $kode_pembayaran
        //     )->get([
        //         'id',
        //         'kode_pembayaran',
        //         'jenis_pembayaran',
        //         'status',
        //         'bulan',
        //         'jumlah',
        //         'total',
        //         'keterangan',
        //     ])->toArray(),
        // ]);
        });


        return redirect('/pembayaran')
            ->with('success', 'Berhasil melakukan update data');


    } catch (\Exception $e) {

        return redirect()->back()
            ->withInput()
            ->with(
                'error',
                'Gagal melakukan update data: ' . $e->getMessage()
            );
    }

    // //hitung total dari seluruh transaksi
    // $total = array_sum($request->jumlah);

    // $data = [
    // 'kode_pembayaran' => $request->kode_pembayaran,
    // 'tanggal'     => $request->tanggal,
    // 'nim' => $request->nomor_induk,
    // 'nama'        => $request->nama,
    // 'kelas'       => $request->kelas,
    // 'jenis_pembayaran' => $request->jenis,
    // 'status'      => $request->status,
    // 'bulan'       => $request->bulan,
    // 'jumlah'      => $request->jumlah,
    // 'total'       => $total,
    // 'keterangan'  => $request->keterangan
    // ];

    // Pembayaran::where('kode_pembayaran', $kode_pembayaran)->update($data);
    // return redirect('/pembayaran')->with('success','berhasil melakukan update data');

    }

    public function destroy($id){
    $data = Pembayaran::where('id', $id)->first();
    Pembayaran::where('id', $id)->delete();
    return redirect('/pembayaran')->with('success', 'data pembayaran telah dihapus');
    }

    }

