<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PengajarController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\DiklatController;
use App\Http\Controllers\JenisDiklatController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\PicController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\AspekPertanyaanController;
use App\Http\Controllers\TipeKuisController;
use App\Http\Controllers\TemplatePertanyaanController;
use App\Http\Controllers\EvaluasiController;
use App\Http\Controllers\PesertaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth')->controller(CategoryController::class)->prefix('category')->group(function () {
    Route::get('/', 'getList');
    Route::get('/{id}', 'getDetail');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::middleware('auth')->controller(SubcategoryController::class)->prefix('subcategory')->group(function () {
    Route::get('/', 'getList');
    Route::get('/{id}', 'getDetail');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::middleware('auth')->controller(JabatanController::class)->prefix('jabatan')->group(function () {
    Route::get('/', 'getList');
    Route::get('/{id}', 'getDetail');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::middleware('auth')->controller(PengajarController::class)->prefix('pengajar')->group(function () {
    Route::get('/', 'getList');
    Route::get('/{id}', 'getDetail');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::middleware('auth')->controller(UnitController::class)->prefix('unit')->group(function () {
    Route::get('/', 'getList');
    Route::get('/{id}', 'getDetail');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::middleware('auth')->controller(DiklatController::class)->prefix('diklat')->group(function () {
    Route::get('/', 'getList');
    Route::get('/{id}', 'getDetail');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::middleware('auth')->controller(JenisDiklatController::class)->prefix('jenis_diklat')->group(function () {
    Route::get('/', 'getList');
    Route::get('/{id}', 'getDetail');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::middleware('auth')->controller(ScoreController::class)->prefix('score')->group(function () {
    Route::get('/', 'getList');
    Route::get('/{id}', 'getDetail');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::middleware('auth')->controller(PicController::class)->prefix('pic')->group(function () {
    Route::get('/', 'getList');
    Route::get('/{id}', 'getDetail');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::middleware('auth')->controller(PesertaController::class)->prefix('peserta')->group(function () {
    Route::get('/', 'getList');
    Route::get('/{id}', 'getDetail');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::middleware('auth')->controller(KategoriController::class)->prefix('kategori')->group(function () {
    Route::get('/', 'getList');
    Route::get('/{id}', 'getDetail');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::middleware('auth')->controller(AspekPertanyaanController::class)->prefix('aspek-pertanyaan')->group(function () {
    Route::get('/', 'getList');
    Route::get('/{id}', 'getDetail');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::middleware('auth')->controller(TipeKuisController::class)->prefix('tipe-kuis')->group(function () {
    Route::get('/', 'getList');
    Route::get('/{id}', 'getDetail');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::middleware('auth')->controller(TemplatePertanyaanController::class)->prefix('template-pertanyaan')->group(function () {
    Route::get('/', 'getList');
    Route::get('/{id}', 'getDetail');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::middleware('auth')->controller(EvaluasiController::class)->prefix('evaluasi')->group(function () {
    Route::get('/', 'getList');
    Route::get('/{id}', 'getDetail');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('me', 'me');
});
