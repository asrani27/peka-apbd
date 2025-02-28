<?php

use App\Http\Controllers\DeviasiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IkpaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RevisiController;
use App\Http\Controllers\SkpdController;
use App\Models\Deviasi;

Route::get('/', [LoginController::class, 'welcome']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/superadmin', [HomeController::class, 'superadmin']);
    Route::get('/superadmin/skpd', [SkpdController::class, 'index']);
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
    Route::post('/superadmin/ikpa/deviasi/edit/{id}', [DeviasiController::class, 'update']);
    Route::get('/superadmin/ikpa/deviasi/delete/{id}', [DeviasiController::class, 'delete']);
    Route::get(
        '/superadmin/ikpa/penyerapan',
        function () {
            Session::flash('warning', 'Aplikasi Kenangan sedang pengembangan');
            return back();
        }
    );
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
