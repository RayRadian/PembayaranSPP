@extends('layout/template')
@section('konten')
<!-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif -->
<a href='/pembayaran' class="btn btn-secondary"><< Kembali</a>
<div class="row justify-content-center">
    <div class="col-md-8">

        <form method="post" action="/pembayaran/update/{{ $data->kode_pembayaran }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- MAIN CARD --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-2">
                    <h6 class="mb-0 fw-bold">Edit Form Pembayaran Siswa</h6>
                </div>
                
                <div class="card-body">
                    
                    {{-- SEKSI 1: DATA SISWA --}}
                    <div class="border-bottom pb-2 mb-3">
                        <span class="badge bg-secondary mb-2">Data Siswa</span>
                        
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label for="kode_pembayaran" class="form-label form-label-sm mb-1">Kode Pembayaran</label>
                                <input type="text" class="form-control form-control-sm bg-light" name="kode_pembayaran" id="kode_pembayaran" value="{{ $data->kode_pembayaran }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="tanggal" class="form-label form-label-sm mb-1">Tanggal</label>
                                <input type="date" id="tanggal" name="tanggal" class="form-control form-control-sm" value="{{ optional($data->tanggal)->format('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="nomor_induk" class="form-label form-label-sm mb-1">Nomor Induk</label>
                                <input type="text" class="form-control form-control-sm" name="nomor_induk" id="nomor_induk" value="{{ $data->nim }}">
                            </div>
                            <div class="col-md-6">
                                <label for="nama" class="form-label form-label-sm mb-1">Nama Siswa</label>
                                <input type="text" class="form-control form-control-sm" name="nama" id="nama" value="{{ $data->nama }}">
                            </div>
                            <div class="col-md-6">
                                <label for="kelas" class="form-label form-label-sm mb-1">Kelas</label>
                                <input type="text" class="form-control form-control-sm" name="kelas" id="kelas" value="{{ $data->kelas }}">
                            </div>
                        </div>
                    </div>

                    {{-- SEKSI 2: CONTAINER TRANSAKSI --}}
                    <div class="mb-2">
                        <span class="badge bg-secondary mb-2">Rincian Transaksi</span>
                        <div id="transaksi-container">
                            
                            <!-- {{-- LOOPING ARRAY TRANSAKSI DARI DATABASE --}}
                            @if(!empty($data->jenis_pembayaran) && is_array($data->jenis_pembayaran))
                                @foreach($data->jenis_pembayaran as $index => $valJenis)
                                <div class="transaksi border rounded p-2 mb-2 bg-light">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fw-bold small judul-transaksi text-primary">Transaksi {{ $index + 1 }}</span>
                                        @if($index > 0)
                                            <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2 hapusTransaksi" style="font-size: 0.75rem;">Hapus</button>
                                        @endif
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-md-3">
                                            <label class="form-label form-label-sm mb-1">Jenis</label>
                                            <select name="jenis[]" class="form-select form-select-sm">
                                                <option value="">Pilih Jenis</option>
                                                <option value="dsp" {{ ($valJenis == 'dsp') ? 'selected' : '' }}>DSP</option>
                                                <option value="spp" {{ ($valJenis == 'spp') ? 'selected' : '' }}>SPP</option>
                                                <option value="praktikum" {{ ($valJenis == 'praktikum') ? 'selected' : '' }}>Praktikum</option>
                                                <option value="osis" {{ ($valJenis == 'osis') ? 'selected' : '' }}>OSIS</option>
                                                <option value="komputer" {{ ($valJenis == 'komputer') ? 'selected' : '' }}>Komputer</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label form-label-sm mb-1">Status</label>
                                            <select name="status[]" class="form-select form-select-sm">
                                                <option value="">Pilih Status</option>
                                                <option value="tunai" {{ (isset($data->status[$index]) && $data->status[$index] == 'tunai') ? 'selected' : '' }}>Tunai</option>
                                                <option value="tunggakan" {{ (isset($data->status[$index]) && $data->status[$index] == 'tunggakan') ? 'selected' : '' }}>Tunggakan</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label form-label-sm mb-1">Bulan</label>
                                            <select name="bulan[]" class="form-select form-select-sm">
                                                <option value="">Pilih Bulan</option>
                                                @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $bln)
                                                    <option value="{{ $bln }}" {{ (isset($data->bulan[$index]) && $data->bulan[$index] == $bln) ? 'selected' : '' }}>{{ $bln }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label form-label-sm mb-1">Jumlah (Rp)</label>
                                            <input type="number" class="form-control form-control-sm input-jumlah" name="jumlah[]" value="{{ $data->jumlah[$index] ?? 0 }}" placeholder="0">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif -->
                            @foreach($transaksi as $index => $item)

                            <div class="transaksi border rounded p-2 mb-2 bg-light">
                            {{--id transaksi database--}}    
                            <input type="hidden" name="id[]" value="{{ $item->id }}">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold small judul-transaksi text-primary">
                                        Transaksi {{ $index + 1 }}
                                    </span>

                                    @if($index > 0)
                                        <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2 hapusTransaksi" style="font-size: 0.75rem;">Hapus</button>
                                    @endif

                                </div>

                                <div class="row g-2">
                                    {{-- JENIS --}}
                                    <div class="col-md-3">
                                        <label class="form-label form-label-sm mb-1">Jenis</label>
                                        <select name="jenis[]" class="form-select form-select-sm">
                                            <option value="">Pilih Jenis</option>
                                            <option value="dsp" {{ $item->jenis_pembayaran == 'dsp' ? 'selected' : '' }}>DSP</option>
                                            <option value="spp" {{ $item->jenis_pembayaran == 'spp' ? 'selected' : '' }}>SPP</option>
                                            <option value="praktikum" {{ $item->jenis_pembayaran == 'praktikum' ? 'selected' : '' }}>Praktikum</option>
                                            <option value="osis" {{ $item->jenis_pembayaran == 'osis' ? 'selected' : '' }}>OSIS</option>
                                            <option value="komputer" {{ $item->jenis_pembayaran == 'komputer' ? 'selected' : '' }}>Komputer</option>
                                        </select>
                                    </div>
                                    {{-- STATUS --}}
                                    <div class="col-md-3">
                                        <label class="form-label form-label-sm mb-1">Status</label>
                                        <select name="status[]" class="form-select form-select-sm">
                                            <option value="">Pilih Status</option>
                                            <option value="tunai" {{ $item->status == 'tunai' ? 'selected' : '' }}>Tunai</option>
                                            <option value="tunggakan" {{ $item->status == 'tunggakan' ? 'selected' : '' }}>Tunggakan</option>
                                        </select>
                                    </div>
                                    {{-- BULAN --}}
                                    <div class="col-md-3">
                                        <label class="form-label form-label-sm mb-1">Bulan</label>
                                        <select name="bulan[]" class="form-select form-select-sm">
                                            <option value="">Pilih Bulan</option>
                                            @foreach([
                                                'Januari',
                                                'Februari',
                                                'Maret',
                                                'April',
                                                'Mei',
                                                'Juni',
                                                'Juli',
                                                'Agustus',
                                                'September',
                                                'Oktober',
                                                'November',
                                                'Desember'
                                            ] as $bln)
                                                <option value="{{ $bln }}" {{ $item->bulan == $bln ? 'selected' : '' }}>{{ $bln }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- JUMLAH --}}
                                    <div class="col-md-3">
                                        <label class="form-label form-label-sm mb-1">Jumlah (Rp)</label>
                                        <input type="number" class="form-control form-control-sm input-jumlah" name="jumlah[]" value="{{ $item->jumlah }}" placeholder="0">
                                    </div>
                                </div>
                            </div>

                            @endforeach
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
                            <label for="total" class="col-md-3 col-form-label col-form-label-sm fw-bold">Total Pembayaran (Rp) :</label>
                            <div class="col-md-4">
                                <input type="number" class="form-control form-control-sm fw-bold bg-warning bg-opacity-10" id="total" name="total" value="{{$transaksi->sum('jumlah')}}" readonly>
                            </div>
                        </div>

                        <div class="row g-2 align-items-center mb-3">
                            <label for="keterangan" class="col-md-3 col-form-label col-form-label-sm">Keterangan :</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="keterangan" id="keterangan" value="{{ $data->keterangan }}" placeholder="Catatan tambahan (opsional)">
                            </div>
                        </div>
                    </div>

                </div>

                {{-- FOOTER / SIMPAN --}}
                <div class="card-footer bg-light d-flex justify-content-end py-2">
                    <button type="submit" class="btn btn-primary btn-sm px-4">
                        Update Transaksi
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
    const grandTotalInput = document.getElementById('total');

    function hitungTotal() {
        let total = 0;
        const inputJumlah = container.querySelectorAll('.input-jumlah');
        
        inputJumlah.forEach(function (input) {
            const val = parseFloat(input.value) || 0;
            total += val;
        });

        grandTotalInput.value = total;
    }

    // Jalankan kalkulasi total saat halaman dibuka
    hitungTotal();

    container.addEventListener('input', function (e) {
        if (e.target.classList.contains('input-jumlah')) {
            hitungTotal();
        }
    });

    tombolTambah.addEventListener('click', function () {
        const transaksiBaru = document.createElement('div');
        transaksiBaru.classList.add('transaksi', 'border', 'rounded', 'p-2', 'mb-2', 'bg-light');

        transaksiBaru.innerHTML = `
        <input type="hidden" name="id[]" value="">
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

    container.addEventListener('click', function (e) {
        if (e.target.classList.contains('hapusTransaksi')) {
            e.target.closest('.transaksi').remove();
            renumberTransaksi();
            hitungTotal();
        }
    });

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