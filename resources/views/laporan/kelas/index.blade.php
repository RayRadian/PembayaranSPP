@extends('layout/template')
@section('konten')


<h3>Data Kelas</h3><br>
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