<?php

namespace App\Http\Controllers;

use App\Exports\SiswaExport;
use App\Exports\KelasExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;


class ReportController extends Controller
{
    
public function export()
{
return Excel::download(new SiswaExport, 'datasiswa.xlsx');
}

function siswa(){
return view('report.index');
}

function kelas(){
return view('laporan.kelas.index');
}

public function exportkelas()
{
    return Excel::download(new KelasExport, 'datakelas.xlsx');
}


// function btndownload(){
// return view('report/export');
// }

}
