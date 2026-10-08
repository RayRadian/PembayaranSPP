@extends('layout/template')
@section('konten')
<!-- <tr>
  <td colspan="2">
    <div class="d-flex align-items-center">
      <a href="/report/export" class="btn btn-primary me-5" style="margin-right: 500px;">Export Excel</a>
    </div>
  </td>
</tr> -->
<h3>Data Siswa</h3><br>
<a href="{{ route('report.export') }}" 
   onclick="showLoading()"
   class="btn btn-success">
   Download Excel
</a>

<script>
function showLoading(){
    alert("Download sedang diproses...");
}
</script>

@endsection