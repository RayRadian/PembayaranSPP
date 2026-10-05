@if ($errors->any())
<div id="failedAlert" class="alert alert-danger">
<ul>
@foreach ($errors->all() as $item)
<li>{{ $item }}</li>
@endforeach
</ul>
</div>
@endif


@if (Session::get('success'))
<div id="successAlert" class="alert alert-success">{{ Session:: get('success')}}</div>
@endif


<script>
    // Hilangkan alert setelah 3 detik (3000 ms)
    setTimeout(function () {
        let alert = document.getElementById('successAlert');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500); // hapus dari DOM setelah fade out
        }
    }, 5000);
</script>

<script>
    // Hilangkan alert setelah 3 detik (3000 ms)
    setTimeout(function () {
        let alert = document.getElementById('failedAlert');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500); // hapus dari DOM setelah fade out
        }
    }, 5000);
</script>



