@extends('layout/template')
@section('konten')
   
<!-- <div class="row justify-content-center">
<div class="col-md-8">

<form method="post" action="/pembayaran/store" enctype="multipart/form-data">
@csrf
<div class="mb-3">
<label for="tanggal">Pilih Tanggal :</label>
<input type="date" id="tanggal" name="tanggal">
</div>    
<div class="mb-3">
<label for="nomor_induk" class="form-label">Nomor Induk</label>
<input type="text" class="form-control" name="nomor_induk" id="nomor_induk" value="{{ Session::get('nomor_induk')}}">
</div>
<div class="mb-3">
<label for="nama" class="form-label">Nama</label>
<input type="text" class="form-control" name="nama" id="nama" value="{{ Session::get('nama')}}">
</div>
<div class="mb-3">
<label for="kelas" class="form-label">Kelas</label>
<input type="text" class="form-control" name="kelas" id="kelas" value="{{ Session::get('kelas')}}">
</div>
<div class="mb-3">
<label for="jenis" class="form-label">Jenis Pembayaran</label>
<select name="jenis" class="form-select me-2" style="width:180px;">
<option value="">Pilih Jenis Pembayaran</option>
<option value="dsp">Dana Sumbangan Pendidikan</option>
<option value="spp">SPP</option>
<option value="praktikum">Praktikum</option>
<option value="osis">OSIS</option>
<option value="komputer">Komputer</option>
</select>
</div>
<div class="mb-3">
<label for="status" class="form-label">Status</label>
<select name="status" class="form-select me-2" style="width:180px;">
<option value="">Pilih Status Pembayaran</option>
<option value="tunai">Tunai</option>
<option value="tunggakan">Tunggakan</option>
</select>    
</div>
<div class="mb-3">
<label for="bulan" class="form-label">Bulan</label>
<select name="bulan" class="form-select me-2" style="width:180px;" >
<option value="">Pilih Bulan</option>
<option value="01">Januari</option>
<option value="02">Februari</option>
<option value="03">Maret</option>
<option value="04">April</option>
<option value="05">Mei</option>
<option value="06">Juni</option>
<option value="07">Juli</option>
<option value="08">Agustus</option>
<option value="09">September</option>
<option value="10">Oktober</option>
<option value="11">November</option>
<option value="12">Desember</option>
</select>
</div>
<div class="mb-3">
<label for="jumlah" class="form-label">Jumlah</label>
<input type="number" class="form-control" name="jumlah" id="jumlah" value="{{Session::get('jumlah')}}">
</div>
<div class="mb-3">
<label for="total" class="form-label">Total</label>
<input type="number" class="form-control" name="total" id="total" value="{{Session::get('total')}}">
</div>
<div class="mb-3">
<label for="keterangan" class="form-label">Keterangan</label>
<input type="text" class="form-control" name="keterangan" id="keterangan" value="{{Session::get('keterangan')}}">
</div>
<div class="mb-3">
<button type="submit" class="btn btn-primary">Simpan</button>
</div>

</form>

</div>
</div>  -->
<!-- @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

 Alert jika terjadi kesalahan Validasi Form
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif -->



<div class="row justify-content-center">
    <div class="col-md-8">

        <form method="post" action="/pembayaran/store" enctype="multipart/form-data">
            @csrf

            {{-- MAIN CARD --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-2">
                    <h6 class="mb-0 fw-bold">Form Pembayaran Siswa</h6>
                </div>
                
                <div class="card-body">
                    
                    {{-- SEKSI 1: DATA SISWA --}}
                    <div class="border-bottom pb-2 mb-3">
                        <span class="badge bg-secondary mb-2">Data Siswa</span>
                        
                        
                            <div class="col-md-4">
                                <label for="kode_pembayaran" class="form-label form-label-sm mb-1">Kode Pembayaran</label>
                                <input type="text" class="form-control form-control-sm bg-light" name="kode_pembayaran" id="kode_pembayaran" value="{{$kodeOtomatis}}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="tanggal" class="form-label form-label-sm mb-1">Tanggal</label>
                                <input type="date" id="tanggal" name="tanggal" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-4">
                                <label for="nomor_induk" class="form-label form-label-sm mb-1">Nomor Induk</label>
                                <input type="text" class="form-control form-control-sm" name="nomor_induk" id="nomor_induk" value="{{ Session::get('nomor_induk') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="nama" class="form-label form-label-sm mb-1">Nama Siswa</label>
                                <input type="text" class="form-control form-control-sm" name="nama" id="nama" value="{{ Session::get('nama') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="kelas" class="form-label form-label-sm mb-1">Kelas</label>
                                <input type="text" class="form-control form-control-sm" name="kelas" id="kelas" value="{{ Session::get('kelas') }}">
                            </div>
                        
                    </div>

                    {{-- SEKSI 2: CONTAINER TRANSAKSI --}}
                    <div class="mb-2">
                        <span class="badge bg-secondary mb-2">Rincian Transaksi</span>
                        <div id="transaksi-container">
                            
                            {{-- TRANSAKSI PERTAMA --}}
                            <div class="transaksi border rounded p-2 mb-2 bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold small judul-transaksi text-primary">Transaksi 1</span>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <label class="form-label form-label-sm mb-1">Jenis</label>
                                        <select name="jenis[]" class="form-select form-select-sm">
                                            <option value="">Pilih Jenis</option>
                                            <option value="dsp">DSP</option>
                                            <option value="spp">SPP</option>
                                            <option value="praktikum">Praktikum</option>
                                            <option value="osis">OSIS</option>
                                            <option value="komputer">Komputer</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label form-label-sm mb-1">Status</label>
                                        <select name="status[]" class="form-select form-select-sm">
                                            <option value="">Pilih Status</option>
                                            <option value="tunai">Tunai</option>
                                            <option value="tunggakan">Tunggakan</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label form-label-sm mb-1">Bulan</label>
                                        <select name="bulan[]" class="form-select form-select-sm">
                                            <option value="">Pilih Bulan</option>
                                            <option value="Januari">Januari</option>
                                            <option value="Februari">Februari</option>
                                            <option value="Maret">Maret</option>
                                            <option value="April">April</option>
                                            <option value="Mei">Mei</option>
                                            <option value="Juni">Juni</option>
                                            <option value="Juli">Juli</option>
                                            <option value="Agustus">Agustus</option>
                                            <option value="September">September</option>
                                            <option value="Oktober">Oktober</option>
                                            <option value="November">November</option>
                                            <option value="Desember">Desember</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label form-label-sm mb-1">Jumlah (Rp)</label>
                                        <input type="number" class="form-control form-control-sm input-jumlah" name="jumlah[]" placeholder="0">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- TOMBOL TAMBAH TRANSAKSI --}}
                    <div class="mb-3">
                        <button type="button" id="tambahTransaksi" class="btn btn-outline-success btn-sm">
                            + Tambah Item Transaksi
                        </button>
                    </div>

                    {{-- SEKSI 3: TOTAL & KETERANGAN --}}
                    <div class="border-top pt-2">
                        <div class="row g-2 align-items-center mb-2">
                            <label for="grand_total" class="col-md-3 col-form-label col-form-label-sm fw-bold">Total Pembayaran (Rp) :</label>
                            <div class="col-md-4">
                                <input type="number" class="form-control form-control-sm fw-bold bg-warning bg-opacity-10" id="grand_total" name="grand_total" value="0" readonly>
                            </div>
                        </div>

                        <div class="row g-2 align-items-center mb-3">
                            <label for="keterangan" class="col-md-3 col-form-label col-form-label-sm">Keterangan :</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="keterangan" id="keterangan" value="{{ Session::get('keterangan') }}" placeholder="Catatan tambahan (opsional)">
                            </div>
                        </div>
                    </div>

                </div>

                {{-- FOOTER / SIMPAN --}}
                <div class="card-footer bg-light d-flex justify-content-end py-2">
                    <button type="submit" class="btn btn-primary btn-sm px-4">
                        Simpan Transaksi
                    </button>
                </div>
            </div>

        </form>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('transaksi-container');
    const tombolTambah = document.getElementById('tambahTransaksi');
    const grandTotalInput = document.getElementById('grand_total');

    // Fungsi menghitung akumulasi total jumlah
    function hitungTotal() {
        let total = 0;
        const inputJumlah = container.querySelectorAll('.input-jumlah');
        
        inputJumlah.forEach(function (input) {
            const val = parseFloat(input.value) || 0;
            total += val;
        });

        grandTotalInput.value = total;
    }

    // Event listener untuk perhitungan otomatis saat nilai jumlah diisi/diubah
    container.addEventListener('input', function (e) {
        if (e.target.classList.contains('input-jumlah')) {
            hitungTotal();
        }
    });

    // Event listener untuk menambah elemen transaksi baru
    tombolTambah.addEventListener('click', function () {
        const transaksiBaru = document.createElement('div');
        transaksiBaru.classList.add('transaksi', 'border', 'rounded', 'p-2', 'mb-2', 'bg-light');

        transaksiBaru.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold small judul-transaksi text-primary">Transaksi</span>
                <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2 hapusTransaksi" style="font-size: 0.75rem;">Hapus</button>
            </div>
            <div class="row g-2">
                <div class="col-md-3">
                    <label class="form-label form-label-sm mb-1">Jenis</label>
                    <select name="jenis[]" class="form-select form-select-sm">
                        <option value="">Pilih Jenis</option>
                        <option value="dsp">DSP</option>
                        <option value="spp">SPP</option>
                        <option value="praktikum">Praktikum</option>
                        <option value="osis">OSIS</option>
                        <option value="komputer">Komputer</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label form-label-sm mb-1">Status</label>
                    <select name="status[]" class="form-select form-select-sm">
                        <option value="">Pilih Status</option>
                        <option value="tunai">Tunai</option>
                        <option value="tunggakan">Tunggakan</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label form-label-sm mb-1">Bulan</label>
                    <select name="bulan[]" class="form-select form-select-sm">
                        <option value="">Pilih Bulan</option>
                        <option value="Januari">Januari</option>
                        <option value="Februari">Februari</option>
                        <option value="Maret">Maret</option>
                        <option value="April">April</option>
                        <option value="Mei">Mei</option>
                        <option value="Juni">Juni</option>
                        <option value="Juli">Juli</option>
                        <option value="Agustus">Agustus</option>
                        <option value="September">September</option>
                        <option value="Oktober">Oktober</option>
                        <option value="November">November</option>
                        <option value="Desember">Desember</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label form-label-sm mb-1">Jumlah (Rp)</label>
                    <input type="number" class="form-control form-control-sm input-jumlah" name="jumlah[]" placeholder="0">
                </div>
            </div>

        `;

        container.appendChild(transaksiBaru);
        renumberTransaksi();
    });

    // Event listener untuk menghapus baris transaksi
    container.addEventListener('click', function (e) {
        if (e.target.classList.contains('hapusTransaksi')) {
            e.target.closest('.transaksi').remove();
            renumberTransaksi();
            hitungTotal();
        }
    });

    // Penomoran ulang judul transaksi
    function renumberTransaksi() {
        const daftarTransaksi = container.querySelectorAll('.transaksi');
        daftarTransaksi.forEach((item, index) => {
            const judul = item.querySelector('.judul-transaksi');
            if (judul) {
                judul.textContent = `Transaksi ${index + 1}`;
            }
        });
    }
});
</script>




@endsection
