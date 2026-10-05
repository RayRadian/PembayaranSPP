@extends('layout/template')

@section('konten')

<div>
<a href='/kelas' class="btn btn-secondary"><< Kembali</a>
<form method="post" action="/kelas/show" >
<h1>{{ $data->nama }}</h1>
<p>
  <b>Nomor Induk :</b> {{ $data->nomor_induk }}
</p>
<p>
  <b>Kelas :</b> {{$data->kelas}}
</p>
<p>
  <b>Tahun Ajaran :</b> {{ $data->tahun_ajaran }}
</p>
</div>

</form>
@endsection
