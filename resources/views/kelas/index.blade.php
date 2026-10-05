@extends('layout/template')
@section('konten')
@include('komponen.nodata')
<!-- @if($data->count() ==0)
<div class="alert alert-danger">
Data tidak ditemukan
</div>
@endif -->
<tr>
  <td colspan="2">
    <div class="d-flex align-items-center">
      <a href="/kelas/create" class="btn btn-primary me-5" style="margin-right: 500px;">+ Tambah Data Kelas</a>
      <!-- <form action="kelas" method="GET" class="d-flex">
        <input type="text" style="width: 250px;" name="search" class="form-control me-2" placeholder="Cari kelas..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-secondary">Cari</button>
      </form> -->
      <form action="{{ url('kelas') }}" method="GET" class="d-flex">
       <!-- Combobox Kelas -->
    <select name="kelas" class="form-select me-2" style="width:180px;">
        <option value="">Semua Kelas</option>
        @foreach($kelasList as $kelas)
            <option value="{{ $kelas }}"
                {{ request('kelas') == $kelas ? 'selected' : '' }}>
                {{ $kelas }}
            </option>
        @endforeach
    </select>
    <!-- Combobox Tahun Ajaran -->
    <select name="tahun_ajaran" class="form-select me-2" style="width:200px;">
        <option value="">Semua Tahun</option>
        @foreach($tahunList as $tahun)
            <option value="{{ $tahun }}"
                {{ request('tahun_ajaran') == $tahun ? 'selected' : '' }}>
                {{ $tahun }}
            </option>
        @endforeach
    </select>

      <button type="submit" class="btn btn-secondary">Cari</button>

      </form>  
    </div>
  </td>
</tr>

<table class="table" style="width: 100%;">
<thead>
<tr>    
<th>Nomor Induk</th>
<th>Nama</th>
<th>Kelas</th>
<th>Tahun Ajaran</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>
@foreach ($data as $item)
<tr>    
<td>{{$item->nomor_induk }}</td>
<td>{{$item->nama }}</td>
<td>{{$item->kelas}}</td>
<td>{{$item->tahun_ajaran }}</td>
<td><a class='btn btn-secondary btn-sm' href="/kelas/show/{{ $item->id }}">Detail</a>
<a class='btn btn-warning btn-sm' href="/kelas/edit/{{ $item->id }}">Edit</a>
<form onsubmit="return confirm('Are you sure to delete?')" class='d-inline' action="/kelas/destroy/{{ $item->id }}" method='post'>
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
