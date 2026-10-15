<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/register', [LoginController::class, 'daftar'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.post');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::resource('dashboard', DashboardController::class);
    Route::middleware(['is_admin'])->group(function () {       
        Route::resource('users', UsersController::class);
        Route::resource('absensi', AbsensiController::class);
        Route::resource('cuti', CutiController::class);
        Route::resource('divisi', DivisiController::class);
        Route::resource('jabatan', JabatanController::class);
        Route::resource('jenis_cuti', JenisCutiController::class);
        Route::resource('karyawan', KaryawanController::class);
    });
    Route::middleware(['is_karyawan'])->group(function () {       
        Route::resource('absen_karyawan', AbsenKaryawanController::class);
        Route::resource('pengajuan_cuti', PengajuanCutiController::class);
    });
});


