@extends('layout/template')
@section('konten')

<a href="{{ route('laporan.kelas.export') }}"
onclick="showLoading()"
class="btn btn-success">
Download Excel
</a>

<script>
function showLoading(){
alert("Download sedang diproses...")
}
</script>

@endsection