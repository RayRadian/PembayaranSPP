<?php

namespace App\Http\Controllers;

use App\Exports\SiswaExport;
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

function index(){
return view('report/index');
}


// function btndownload(){
// return view('report/export');
// }

}
