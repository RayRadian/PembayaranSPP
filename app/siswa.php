<?php

namespace App;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{
    //use HasFactory;
    protected $table = "siswa";
    protected $fillable = ['nomor_induk','nama','kelas','alamat','foto'];
}
