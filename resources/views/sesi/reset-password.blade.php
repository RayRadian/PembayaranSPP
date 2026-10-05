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

<body>
<div class="login-card">

<h2 class="text-center mb-4">Reset Password</h2>

@if (session('success'))
    <div>{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div>{{ $errors->first() }}</div>
@endif

<form action="/sesi/resetpassword" method="POST">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" required class="form-control">
    </div>
    <div class="mb-3">
    <label>Password Baru</label>
    <input type="password" name="password" required class="form-control">
    </div>
    <div class="mb-3">
    <label>Konfirmasi Password</label>
    <input type="password" name="password_confirmation" required class="form-control">
    </div>
    <div class="mb-3 d-grid">
    <button name="submit" type="submit" class="btn btn-primary">Reset Password</button>
    </div>
</form>

</div>
</body>
</html>


@endsection 