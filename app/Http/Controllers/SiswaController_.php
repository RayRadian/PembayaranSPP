<?php

namespace App\Http\Controllers;
use App\siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    

function index ()
{
  //$data = siswa::all();
  $data = siswa::orderBy('nomor_induk', 'desc')->paginate(2);
  return view('siswa/index')->with('data', $data); 
  //return $data;
  //return '<h1>Saya SISWA dari Controller</h1>';
}

function detail ($id)
{
  //return "<h1>saya Siswa dari Controller dengan ID $id</h1>";
  $data = siswa::where('nomor_induk', $id)->first();
  return view('siswa/show')-> with('data', $data);
}

function create() {


}

}
