@extends('layout/aplikasi')
@section('konten')
<h1>{{ $judul }} </h1>
      <h1>Halaman Kontak</h1>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo rerum error praesentium. Animi distinctio explicabo sequi. Iure aspernatur odit labore in alias dolore accusamus nemo similique, possimus rem nihil recusandae.</p>
<p>
<ul>
    <li>Email : {{$kontak['email']}} </li>
    <li>Youtube : {{$kontak['youtube']}} </li>
</ul>
</p>
@endsection