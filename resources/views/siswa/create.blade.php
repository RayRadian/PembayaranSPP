@extends('layout/template')

@section('konten')
<!-- <div class="container mt-4"> -->   
<div class="row justify-content-center">
<div class="col-md-8">

<form method="post" action="/siswa/store" enctype="multipart/form-data">
@csrf
<div class="mb-3">
<label for="nomor_induk" class="form-label">Nomor Induk</label>
<input type="text" class="form-control" name="nomor_induk" id="nomor_induk" value="{{ Session::get('nomor_induk')}}">
</div>
<div class="mb-3">
<label for="nama" class="form-label">Nama</label>
<input type="text" class="form-control" name="nama" id="nama" value="{{ Session::get('nama')}}">
</div>
<div class="mb-3">
<label for="kelas" class="form-label">Tempat & Tanggal Lahir</label>
<input type="text" class="form-control" name="ttl" id="ttl" value="{{ Session::get('ttl')}}">
</div>
<div class="mb-3">
<label for="alamat" class="form-label">Alamat</label>
<textarea class="form-control" name="alamat">{{Session::get('alamat')}}</textarea>
</div>
<div class="mb-3">
<label for="foto" class="form-label">Foto</label>
<input type="file" class="form-control" name="foto" id="foto"> 
</div>
<div class="mb-3">
<button type="submit" class="btn btn-primary">Simpan</button>
</div>

</form>

</div>
</div>
<!--</div>-->


@endsection

<!--
//value="{{ Session::get('nomor_induk')}}"
//value="{{ Session::get('nama')}}"
{{ Session::get('alamat') }}
-->
