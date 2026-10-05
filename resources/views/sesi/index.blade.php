@extends('layout/Aplikasi')

@section('konten')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
<h1 class="text-center mb-4">Login</h1>
<form action="/sesi/login" method="post">
@csrf 
<div class="mb-3">
<label for="email" class="form-label">Email</label>
<input type="email" value="{{ Session::get('email') }}" name="email" class="form-control"> 
</div>
<div class="mb-3">
<label for="password" class="form-label">Password</label>
<input type="password"  name="password" class="form-control"> 
</div>
<div class="mb-3 d-grid">
<button name="submit" type="submit" class="btn btn-primary">Login</button>
</div>
<div class="d-flex justify-content-between">
<div>
  <tr><td><h6>Belum punya akun ?</h6>
  <a href="/sesi/register">Daftar disini</a>
</td>
</tr>
  </div>
  <div>
<tr><td><a href="/sesi/gantipassword">Lupa Password ?</a></td></tr>
  </div>
  </div>
</form>
</div>
</body>
</html>

@endsection 