<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
    //use HasFactory;
protected $table ='kelas';

protected $fillable = [
'nomor_induk',
'nama',
'kelas',
'tahun_ajaran'
];

}
