@extends('layout/aplikasi')

@section('konten')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ubah Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
 <style>
    body {
      background-color: #f0f0f0; /* warna abu muda */
      height: 100vh;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-card {
      background-color: #fff; /* form tetap putih */
      padding: 40px 30px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      width: 400px;
    }
  </style>
  </head>
<!-- <body>
<div class="login-card">    
<h1 class="text-center mb-4">Password Baru</h1>
<form action="/sesi/create" method="post">
@csrf 
<div class="mb-3">
<label for="password" class="form-label">Password</label>
<input type="password"  name="password" class="form-control"> 
</div>
<div class="mb-3">
<label for="retypepassword" class="form-label">Ketik lagi Password</label>
<input type="retypepassword"  name="retypepassword" class="form-control"> 
</div>
<div class="mb-3 d-grid">
<button name="submit" type="submit" class="btn btn-primary">Simpan</button>
</div>

</form>
</div>
</body> -->

<body>
<div class="login-card">  
<h2 class="text-center mb-4">Lupa Password</h2>

@if (session('success'))
    <div>{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div>{{ $errors->first() }}</div>
@endif

<form action="/sesi/gantipassword" method="POST">
    @csrf
    <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" required class="form-control">
    </div>
  <div class="mb-3 d-grid">
    <button name="submit" type="submit" class="btn btn-primary">Kirim Link Reset</button>
  </div>
</form>
  </div>
  </body>
</html>


@endsection 