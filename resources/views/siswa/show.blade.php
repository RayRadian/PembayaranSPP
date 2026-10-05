@extends('layout/template')

@section('konten')

<div>
<a href='/siswa' class="btn btn-secondary"><< Kembali</a>
<form method="post" action="/siswa/show" >
<h1>{{ $data->nama }}</h1>
<p>
  <b>Nomor Induk :</b> {{ $data->nomor_induk }}
</p>
<p>
  <b>Tempat & Tanggal Lahir :</b> {{$data->ttl}}
</p>
<p>
  <b>Alamat :</b> {{ $data->alamat }}
</p>
</div>

</form>
@endsection
