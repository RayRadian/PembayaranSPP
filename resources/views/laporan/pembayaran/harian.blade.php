@extends('layout/template')
@section('konten')

<div class="container-fluid">

    <!-- Judul -->
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">
                <i class="fas fa-calendar-day"></i>
                Rekap Pembayaran Harian
            </h4>
        </div>
    </div>

    <!-- Filter -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-search"></i>
                Pencarian
            </h3>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Tanggal Awal -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal_awal">Tanggal Awal</label>
                        <input
                            type="date"
                            class="form-control"
                            id="tanggal_awal"
                            name="tanggal_awal"                >
                    </div>
                </div>

                <!-- Tanggal Akhir -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal_akhir">Tanggal Akhir</label>
                        <input
                            type="date"
                            class="form-control"
                            id="tanggal_akhir"
                            name="tanggal_akhir">
                    </div>
                </div>

                <!-- Tombol Proses -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div>
                            <button
                                type="button"
                                id="btnProses"
                                class="btn btn-primary">
                                <i class="fas fa-search"></i>
                                Proses
                            </button>

                            <button
                                type="button"
                                id="btnReset"
                                class="btn btn-secondary">
                                <i class="fas fa-sync"></i>
                                Reset
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <!-- Tabel -->
    <div class="card">

        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-table"></i>
                Data Pembayaran
            </h3>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table
                    id="tabelPembayaran"
                    class="table table-bordered table-striped table-hover"
                    style="width:100%"
                >

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode Pembayaran</th>
                            <th>Tanggal</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Jenis Pembayaran</th>
                            <th>Status</th>
                            <th>Bulan</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>
                        {{-- Data AJAX akan ditampilkan di sini --}}
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')

<script>
$(document).ready(function () {

    // Tombol Proses
    $('#btnProses').click(function () {

        let tanggalAwal = $('#tanggal_awal').val();
        let tanggalAkhir = $('#tanggal_akhir').val();

        if (tanggalAwal === '') {
            alert('Silakan pilih tanggal awal.');
            return;
        }

        if (tanggalAkhir === '') {
            alert('Silakan pilih tanggal akhir.');
            return;
        }

        if (tanggalAwal > tanggalAkhir) {
            alert('Tanggal awal tidak boleh lebih besar dari tanggal akhir.');
            return;
        }

        // Sementara belum mengambil data
        console.log('Tanggal Awal:', tanggalAwal);
        console.log('Tanggal Akhir:', tanggalAkhir);

        alert('Proses pencarian: ' + tanggalAwal + ' s/d ' + tanggalAkhir);
    });


    // Tombol Reset
    $('#btnReset').click(function () {

        $('#tanggal_awal').val('');
        $('#tanggal_akhir').val('');
        $('#tabelPembayaran tbody').empty();

    });

});
</script>

@endpush
@endsection
