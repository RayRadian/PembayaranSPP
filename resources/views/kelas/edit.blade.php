@extends('layout/template')

@section('konten')

<a href='/kelas' class="btn btn-secondary"><< Kembali</a>

<div class="row justify-content-center">
<div class="col-md-8">

<form method="post" action="/kelas/update/{{ $data->id }}" enctype="multipart/form-data">
@csrf
@method('put')
<div class="mb-3">
<h1>Nomor Induk: {{ $data->nomor_induk }}</h1>
</div>
<div class="mb-3">
<label for="nama" class="form-label">Nama</label>
<input type="text" class="form-control" name="nama" id="nama" value="{{ $data->nama }}">
</div>
<div class="mb-3">
<label for="kelas" class="form-label">Kelas</label>
<input type="text" class="form-control" name="kelas" id="kelas" value="{{ $data->kelas }}">
</div>
<div class="mb-3">
<label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
<input type="text" class="form-control" name="tahun_ajaran" id="tahun_ajaran" value="{{ $data->tahun_ajaran }}">
</div>

<div class="mb-3">
<button type="submit" class="btn btn-primary">Update</button>
</div>


</form>

</div>
</div>

@endsection

