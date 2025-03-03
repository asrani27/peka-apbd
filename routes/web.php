<?php

use App\Models\Deviasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IkpaController;
use App\Http\Controllers\SkpdController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RevisiController;
use App\Http\Controllers\DeviasiController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PenyerapanController;
use App\Http\Controllers\AdminDeviasiController;
use App\Http\Controllers\AdminPenyerapanController;
use App\Http\Controllers\AdminRevisiController;

Route::get('/', [LoginController::class, 'welcome']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'admin']);

    Route::get('/admin/ikpa/deviasi', [AdminDeviasiController::class, 'index']);
    Route::get('/admin/ikpa/deviasi/add', [AdminDeviasiController::class, 'add']);
    Route::post('/admin/ikpa/deviasi/add', [AdminDeviasiController::class, 'store']);
    Route::get('/admin/ikpa/deviasi/edit/{id}', [AdminDeviasiController::class, 'edit']);
    Route::post('/admin/ikpa/deviasi/edit/{id}', [AdminDeviasiController::class, 'update']);
    Route::get('/admin/ikpa/deviasi/delete/{id}', [AdminDeviasiController::class, 'delete']);

    Route::get('/admin/ikpa/penyerapan', [AdminPenyerapanController::class, 'index']);

    Route::get('/admin/ikpa/revisi', [AdminRevisiController::class, 'index']);
    Route::get('/admin/ikpa/revisi/{id}', [AdminRevisiController::class, 'detail']);
    Route::post('/admin/ikpa/revisi/keberatan/{id}', [AdminRevisiController::class, 'storeKeberatan']);
    Route::get('/admin/ikpa/revisi/keberatan/delete/{id}', [AdminRevisiController::class, 'deleteKeberatan']);
    Route::get(
        '/admin/ikpa/capaian',
        function () {
            Session::flash('warning', 'Aplikasi dalam pengembangan');
            return back();
        }
    );
});
Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/superadmin', [HomeController::class, 'superadmin']);
    Route::get('/superadmin/penilaian', [PenilaianController::class, 'index']);
    Route::get('/superadmin/skpd', [SkpdController::class, 'index']);
    Route::get('/superadmin/skpd/createuser/{id}', [SkpdController::class, 'createuser']);
    Route::get('/superadmin/skpd/resetpass/{id}', [SkpdController::class, 'resetpass']);
    Route::get('/superadmin/ikpa', [IkpaController::class, 'index']);
    Route::get('/superadmin/ikpa/add', [IkpaController::class, 'create']);
    Route::post('/superadmin/ikpa/add', [IkpaController::class, 'store']);
    Route::get('/superadmin/ikpa/edit/{id}', [IkpaController::class, 'edit']);
    Route::post('/superadmin/ikpa/edit/{id}', [IkpaController::class, 'update']);
    Route::get('/superadmin/ikpa/delete/{id}', [IkpaController::class, 'delete']);

    Route::get('/superadmin/ikpa/revisi', [IkpaController::class, 'revisi']);
    Route::get('/superadmin/ikpa/revisi/{id}', [RevisiController::class, 'index']);
    Route::post('/superadmin/ikpa/revisi/{id}', [RevisiController::class, 'store']);
    Route::get('/superadmin/ikpa/revisi/{id}/edit/{revisi_id}', [RevisiController::class, 'edit']);
    Route::post('/superadmin/ikpa/revisi/{id}/edit/{revisi_id}', [RevisiController::class, 'update']);
    Route::get('/superadmin/ikpa/revisi/{id}/delete/{revisi_id}', [RevisiController::class, 'delete']);

    Route::get('/superadmin/ikpa/deviasi', [DeviasiController::class, 'index']);
    Route::get('/superadmin/ikpa/deviasi/add', [DeviasiController::class, 'add']);
    Route::post('/superadmin/ikpa/deviasi/add', [DeviasiController::class, 'store']);
    Route::get('/superadmin/ikpa/deviasi/edit/{id}', [DeviasiController::class, 'edit']);
    Route::get('/superadmin/ikpa/deviasi/detail/{id}', [DeviasiController::class, 'detail']);
    Route::post('/superadmin/ikpa/deviasi/edit/{id}', [DeviasiController::class, 'update']);
    Route::get('/superadmin/ikpa/deviasi/delete/{id}', [DeviasiController::class, 'delete']);
    Route::get('/superadmin/ikpa/penyerapan', [PenyerapanController::class, 'index']);
    Route::get(
        '/superadmin/ikpa/capaian',
        function () {
            Session::flash('warning', 'Aplikasi Kenangan sedang pengembangan');
            return back();
        }
    );

    Route::get(
        '/superadmin/ikpa/penyerapan/{id}',
        function () {
            Session::flash('warning', 'Aplikasi Kenangan sedang pengembangan');
            return back();
        }
    );
    Route::get(
        '/superadmin/ikpa/capaian/{id}',
        function () {
            Session::flash('warning', 'Aplikasi Kenangan sedang pengembangan');
            return back();
        }
    );
});
Route::get('/logout', function () {
    Auth::logout();
    Session::flash('success', 'Anda Telah Logout');
    return redirect('/');
});
