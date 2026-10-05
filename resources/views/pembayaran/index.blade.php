@extends('layout/template')
@section('konten')
@include('komponen.nodata')
<tr>
  <td colspan="2">
    <div class="d-flex align-items-center">
      <a href="/pembayaran/create" class="btn btn-primary me-5" style="margin-right: 500px;">+ Tambah Data Pembayaran</a>
      <form action="pembayaran" method="GET" class="d-flex">
        <input type="text" style="width: 250px;" name="search" class="form-control me-2" placeholder="Cari nama atau nomor induk..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-secondary">Cari</button>
      </form>
    </div>
  </td>
</tr>

<table class="table" style="width: 100%;">
<thead>
<tr>
<th>Tanggal</th>    
<th>Nomor Induk</th>
<th>Nama</th>
<th>Kelas</th>
<th>Jenis</th>
<th>Bulan</th>
<th>Jumlah</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>
@foreach ($data as $item)
<tr>
<td>{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
<td>{{$item->nim }}</td>
<td>{{$item->nama}}</td>
<td>{{$item->kelas }}</td>
<td>{{$item->jenis_pembayaran }}</td>
<td>{{$item->bulan }}</td>
<td>{{$item->jumlah }}</td>
<td>
<a class='btn btn-warning btn-sm' href="/pembayaran/edit/{{ $item->kode_pembayaran }}">Detail</a>
<form onsubmit="return confirm('Are you sure to delete?')" class='d-inline' action="/pembayaran/destroy/{{ $item->id }}" method='post'>
    @csrf
    @method('Delete')
    <button class="btn btn-danger btn-sm" type="Submit">Delete</button>
</form>

</td>
</tr>    

@endforeach

</tbody>
</table>

{{ $data->links('pagination::bootstrap-5') }}



@endsection