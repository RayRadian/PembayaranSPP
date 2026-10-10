@extends('layout/template')
@section('konten')

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-center">
            <h4 class="mb-0 text-center">Rekap Pembayaran Harian</h4>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="tanggal_awal">Tanggal Awal</label>
                    <input type="date" class="form-control"
                           id="tanggal_awal" name="tanggal_awal">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="tanggal_akhir">Tanggal Akhir</label>
                    <input type="date" class="form-control"
                           id="tanggal_akhir" name="tanggal_akhir">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <div>
                        <button type="button" id="btnProses"
                                class="btn btn-primary">
                            <i class="fas fa-search"></i> Proses
                        </button>

                        <button type="button" id="btnReset"
                                class="btn btn-secondary">
                            <i class="fas fa-sync"></i> Reset
                        </button>

                        <button type="button" id="btnPdf"
                                class="btn btn-danger">
                            <i class="fas fa-file-pdf"></i> Download PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-table"></i> Data Pembayaran
        </h3>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="tabelPembayaran"
                   class="table table-bordered table-striped table-hover"
                   style="width:100%">

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
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody></tbody>

                <tfoot>
                    <tr class="font-weight-bold bg-light">
                        <td colspan="9" class="text-right">
                            TOTAL JUMLAH
                        </td>
                        <td id="totalJumlah">Rp 0</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>


@push('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.4/jspdf.plugin.autotable.min.js"></script>

<script>
(function () {
    'use strict';

    if (typeof window.jQuery === 'undefined') {
        console.error('jQuery belum dimuat.');
        return;
    }

    const $ = window.jQuery;

    $(function () {
        let dataPembayaran = [];
        let periodeAwal = '';
        let periodeAkhir = '';
        let sedangMemuat = false;

        const urlLaporan =
            @json(route('laporan.pembayaran.laporan-harian'));

        const formatRupiah = function (nilai) {
            return 'Rp ' + new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 2
            }).format(Number(nilai) || 0);
        };

        const formatTanggal = function (tanggal) {
            if (!tanggal) return '';

            const bagian = String(tanggal)
                .substring(0, 10)
                .split('-');

            if (bagian.length !== 3) return tanggal;

            return bagian[2] + '-' + bagian[1] + '-' + bagian[0];
        };

        function hitungTotal(data) {
            return data.reduce(function (total, item) {
                return total + (Number(item.jumlah) || 0);
            }, 0);
        }

        function tampilkanTotal(data) {
            $('#totalJumlah').text(formatRupiah(hitungTotal(data)));
        }

        function tampilkanTabel(data) {
            const tbody = $('#tabelPembayaran tbody');
            tbody.empty();

            if (!Array.isArray(data) || data.length === 0) {
                tbody.append(
                    $('<tr>').append(
                        $('<td>', {
                            colspan: 11,
                            class: 'text-center',
                            text: 'Tidak ada data pembayaran.'
                        })
                    )
                );
                return;
            }

            data.forEach(function (item) {
                const tr = $('<tr>');

                const kolom = [
                    item.id,
                    item.kode_pembayaran,
                    formatTanggal(item.tanggal),
                    item.nim,
                    item.nama,
                    item.kelas,
                    item.jenis_pembayaran,
                    item.status,
                    item.bulan,
                    formatRupiah(item.jumlah),
                    item.keterangan
                ];

                kolom.forEach(function (nilai) {
                    $('<td>')
                        .text(nilai == null ? '' : nilai)
                        .appendTo(tr);
                });

                tbody.append(tr);
            });
        }

        // Inisialisasi DataTables agar paginasi maksimal 15 baris.
        function inisialisasiTabel() {
            if (!$.fn.DataTable) {
                console.error(
                    'DataTables belum dimuat. Periksa layout/template.blade.php.'
                );
                return;
            }

            if ($.fn.DataTable.isDataTable('#tabelPembayaran')) {
                $('#tabelPembayaran').DataTable().destroy();
            }

            $('#tabelPembayaran').DataTable({
                pageLength: 15,
                lengthChange: false,
                searching: false,
                ordering: true,
                paging: true,
                info: true,
                autoWidth: false,
                language: {
                    emptyTable: 'Tidak ada data pembayaran',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    infoEmpty: 'Menampilkan 0 data',
                    zeroRecords: 'Data tidak ditemukan',
                    paginate: {
                        first: 'Pertama',
                        last: 'Terakhir',
                        next: 'Berikutnya',
                        previous: 'Sebelumnya'
                    }
                },
                columnDefs: [
                    { targets: [0], width: '50px' }
                ]
            });
        }

        function resetTabel() {
            if ($.fn.DataTable &&
                $.fn.DataTable.isDataTable('#tabelPembayaran')) {
                $('#tabelPembayaran').DataTable().destroy();
            }

            tampilkanTabel([]);
            tampilkanTotal([]);
        }

        // PROSES PENCARIAN
        $(document)
            .off('click.laporan', '#btnProses')
            .on('click.laporan', '#btnProses', function (event) {
                event.preventDefault();

                if (sedangMemuat) return;

                const tombol = $(this);
                const tanggalAwal = $('#tanggal_awal').val();
                const tanggalAkhir = $('#tanggal_akhir').val();

                if (!tanggalAwal || !tanggalAkhir) {
                    alert('Silakan pilih tanggal awal dan tanggal akhir.');
                    return;
                }

                if (tanggalAwal > tanggalAkhir) {
                    alert('Tanggal awal tidak boleh lebih besar dari tanggal akhir.');
                    return;
                }

                sedangMemuat = true;

                tombol.prop('disabled', true)
                    .html('<i class="fas fa-spinner fa-spin"></i> Memproses...');

                $.ajax({
                    url: urlLaporan,
                    method: 'GET',
                    dataType: 'json',
                    cache: false,
                    data: {
                        tanggal_awal: tanggalAwal,
                        tanggal_akhir: tanggalAkhir
                    },

                    success: function (response) {
                        if (!response ||
                            !Array.isArray(response.data)) {
                            alert('Format data dari server tidak sesuai.');
                            return;
                        }

                        dataPembayaran = response.data;
                        periodeAwal = tanggalAwal;
                        periodeAkhir = tanggalAkhir;

                        tampilkanTabel(dataPembayaran);
                        tampilkanTotal(dataPembayaran);
                        inisialisasiTabel();

                        if (dataPembayaran.length === 0) {
                            alert('Tidak ada pembayaran pada rentang tanggal tersebut.');
                        }
                    },

                    error: function (xhr, status, error) {
                        console.error('AJAX gagal:', {
                            statusHTTP: xhr.status,
                            status: status,
                            error: error,
                            response: xhr.responseText
                        });

                        dataPembayaran = [];
                        periodeAwal = '';
                        periodeAkhir = '';

                        resetTabel();

                        let pesan = 'Gagal mengambil data pembayaran.';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            pesan += '\n' + xhr.responseJSON.message;
                        } else if (xhr.status === 404) {
                            pesan = 'Route laporan tidak ditemukan (404).';
                        } else if (xhr.status === 500) {
                            pesan = 'Terjadi kesalahan server Laravel (500).';
                        }

                        alert(pesan);
                    },

                    complete: function () {
                        sedangMemuat = false;

                        tombol.prop('disabled', false)
                            .html('<i class="fas fa-search"></i> Proses');
                    }
                });
            });

        // RESET
        $(document)
            .off('click.laporan', '#btnReset')
            .on('click.laporan', '#btnReset', function () {
                $('#tanggal_awal').val('');
                $('#tanggal_akhir').val('');

                dataPembayaran = [];
                periodeAwal = '';
                periodeAkhir = '';

                resetTabel();
            });

        // DOWNLOAD PDF
        $(document)
            .off('click.laporan', '#btnPdf')
            .on('click.laporan', '#btnPdf', function () {
                if (dataPembayaran.length === 0) {
                    alert('Silakan proses data pembayaran terlebih dahulu.');
                    return;
                }

                if (!window.jspdf || !window.jspdf.jsPDF) {
                    alert('Library PDF belum berhasil dimuat.');
                    return;
                }

                const doc = new window.jspdf.jsPDF('l', 'mm', 'a4');

                if (typeof doc.autoTable !== 'function') {
                    alert('Plugin PDF AutoTable belum berhasil dimuat.');
                    return;
                }

                const totalJumlah = hitungTotal(dataPembayaran);

                doc.setFontSize(16);
                doc.text('REKAP PEMBAYARAN HARIAN', 148, 15, {
                    align: 'center'
                });

                doc.setFontSize(10);
                doc.text(
                    'Periode: ' + formatTanggal(periodeAwal) +
                    ' s/d ' + formatTanggal(periodeAkhir),
                    148, 22, { align: 'center' }
                );

                const baris = dataPembayaran.map(function (item) {
                    return [
                        item.id ?? '',
                        item.kode_pembayaran ?? '',
                        formatTanggal(item.tanggal),
                        item.nim ?? '',
                        item.nama ?? '',
                        item.kelas ?? '',
                        item.jenis_pembayaran ?? '',
                        item.status ?? '',
                        item.bulan ?? '',
                        formatRupiah(item.jumlah),
                        item.keterangan ?? ''
                    ];
                });

                doc.autoTable({
                    startY: 28,
                    head: [[
                        'ID', 'Kode Pembayaran', 'Tanggal', 'NIM',
                        'Nama', 'Kelas', 'Jenis Pembayaran', 'Status',
                        'Bulan', 'Jumlah', 'Keterangan'
                    ]],
                    body: baris,
                    foot: [[
                        {
                            content: 'TOTAL JUMLAH',
                            colSpan: 9,
                            styles: {
                                halign: 'right',
                                fontStyle: 'bold'
                            }
                        },
                        {
                            content: formatRupiah(totalJumlah),
                            styles: { fontStyle: 'bold' }
                        },
                        ''
                    ]],
                    showFoot: 'lastPage',
                    theme: 'grid',
                    styles: {
                        fontSize: 7,
                        cellPadding: 2,
                        overflow: 'linebreak'
                    },
                    headStyles: {
                        fillColor: [41, 128, 185]
                    },
                    footStyles: {
                        fillColor: [230, 230, 230],
                        textColor: [0, 0, 0],
                        fontStyle: 'bold'
                    },
                    margin: {
                        left: 7,
                        right: 7
                    }
                });

                doc.save(
                    'rekap-pembayaran-' + periodeAwal +
                    '-sampai-' + periodeAkhir + '.pdf'
                );
            });
    });
})();
</script>

@endpush
@endsection
