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

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('me', 'me');
});
