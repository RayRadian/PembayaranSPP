@extends('layout/template')
@section('konten')
@include('komponen.nodata')
<tr>
  <td colspan="2">
    <div class="d-flex align-items-center">
      <a href="/siswa/create" class="btn btn-primary me-5" style="margin-right: 500px;">+ Tambah Data Siswa</a>
      <form action="siswa" method="GET" class="d-flex">
        <input type="text" style="width: 250px;" name="search" class="form-control me-2" placeholder="Cari nama atau nomor induk..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-secondary">Cari</button>
      </form>
    </div>
  </td>
</tr>

<table class="table" style="width: 100%;">
<thead>
<tr>
<th>Foto</th>    
<th>Nomor Induk</th>
<th>Nama</th>
<th>Ttl</th>
<th>Alamat</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>
@foreach ($data as $item)
<tr>
<td>@if ($item->foto)
    <img  style="max-width:50px;max-height:50px" src="{{ url('foto').'/'. $item->foto }}"/>
    @endif  </td>    
<td>{{$item->nomor_induk }}</td>
<td>{{$item->nama }}</td>
<td>{{$item->ttl}}</td>
<td>{{$item->alamat }}</td>
<td><a class='btn btn-secondary btn-sm' href="/siswa/show/{{ $item->nomor_induk }}">Detail</a>
<a class='btn btn-warning btn-sm' href="/siswa/edit/{{ $item->nomor_induk }}">Edit</a>
<form onsubmit="return confirm('Are you sure to delete?')" class='d-inline' action="/siswa/destroy/{{ $item->nomor_induk }}" method='post'>
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
<!-- {{ $data->appends(['search' => request('search')])->links() }}-->

<!-- {{ $data->links() }}-->

@endsection

<!--'{{ url('/siswa/'.$item->nomor_induk.'/edit') }}'-->