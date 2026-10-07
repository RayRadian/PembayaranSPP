<?php

use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ReportController; 
use App\Http\Controllers\HalamanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('siswa',[SiswaController::class, 'index'])->middleware('isLogin');
Route::get('siswa/create', 'SiswaController@create')->middleware('isLogin');
Route::post('siswa/store', 'SiswaController@store');
Route::get('/siswa/show/{id}', 'SiswaController@show')->middleware('isLogin');
Route::get('/siswa/edit/{id}', 'SiswaController@edit')->middleware('isLogin');
Route::put('/siswa/update/{id}', 'SiswaController@update');
Route::delete('/siswa/destroy/{id}', 'SiswaController@destroy')->middleware('isLogin');

Route::get('kelas',[KelasController::class, 'index'])->middleware('isLogin');
Route::get('kelas/create', 'KelasController@create')->middleware('isLogin');
Route::post('kelas/store', 'KelasController@store');
Route::get('kelas/show/{id}', 'KelasController@show')->middleware('isLogin');
Route::get('kelas/edit/{id}', 'KelasController@edit')->middleware('isLogin');
Route::put('kelas/update/{id}', 'KelasController@update');
Route::delete('kelas/destroy/{id}', 'KelasController@destroy')->middleware('isLogin');

Route::get('pembayaran',[PembayaranController::class, 'index'])->middleware('isLogin');
Route::get('pembayaran/create', 'PembayaranController@create')->middleware('isLogin');
Route::post('pembayaran/store', 'PembayaranController@store');
Route::get('pembayaran/edit/{kode_pembayaran}', 'PembayaranController@edit')->middleware('isLogin');
Route::put('pembayaran/update/{kode_pembayaran}', 'PembayaranController@update');
Route::delete('pembayaran/destroy/{id}', 'PembayaranController@destroy')->middleware('isLogin');


Route::get('/halaman',[HalamanController::class, 'index']);
Route::get('/kontak',[HalamanController::class, 'kontak']);
Route::get('/tentang',[HalamanController::class, 'tentang']);

Route::get('/', [SessionController::class, 'index']); 
Route::get('/sesi', [SessionController::class, 'index'])->middleware('isTamu');
Route::post('/sesi/login', [SessionController::class, 'login']);
Route::get('/sesi/logout', [SessionController::class, 'logout']);
Route::get('/sesi/register', [SessionController::class, 'register'])->middleware('isTamu');
Route::post('/sesi/create', [SessionController::class, 'create']);
//Route::get('/sesi/gantipassword');
Route::get('/sesi/gantipassword', [SessionController::class, 'lupaPassword'])->middleware('isTamu')->name('password.request');
Route::post('/sesi/gantipassword', [SessionController::class, 'kirimResetPassword'])->middleware('isTamu')->name('password.email');
Route::get('/sesi/resetpassword/{token}', [SessionController::class, 'formResetPassword'])->middleware('isTamu')->name('password.reset');
Route::post('/sesi/resetpassword', [SessionController::class, 'resetPassword'])->middleware('isTamu')->name('password.update');

Route::get('/report', [ReportController::class, 'siswa']);
Route::get('/report/export', [ReportController::class, 'export'])->name('report.export');

Route::get('/users/export', [UserExcelController::class, 'export'])->name('users.export');
Route::get('/users/reportsiswa', [ReportController::class, 'export'])->name('users.reportsiswa'); 

Route::get('/laporan/kelas', [ReportController::class, 'kelas']);
Route::get('/laporan/kelas/export', [ReportController::class, 'exportkelas'])->name('laporan.kelas.export');


Route::get('/laporan/pembayaran', []);




Route::get('/layout', function () {
   return view ('layout.template');
});



