@extends('layout/template')

@section('konten')
   
<div class="row justify-content-center">
<div class="col-md-8">

<form method="post" action="/kelas/store" enctype="multipart/form-data">
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
<label for="kelas" class="form-label">Kelas</label>
<input type="text" class="form-control" name="kelas" id="kelas" value="{{ Session::get('kelas')}}">
</div>
<div class="mb-3">
<label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
<input type="text" class="form-control" name="tahun_ajaran" id="tahun_ajaran" value="{{Session::get('tahun_ajaran')}}">
</div>
<div class="mb-3">
<button type="submit" class="btn btn-primary">Simpan</button>
</div>

</form>

</div>
</div>



@endsection

