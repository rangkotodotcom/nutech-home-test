<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

// Route Auth
Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'checkCredential']);
Route::post('/logout', [AuthController::class, 'logout']);


Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/product/export', [HomeController::class, 'export']);
    Route::resource('product', ProductController::class);
});


Route::get('/link', function () {
    $targetFolder = storage_path('app/public');
    $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
    symlink($targetFolder, $linkFolder);
});

Route::get('/path', function(){
    $targetFolder = base_path().'/storage/app/public';
    $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage';

    dd([$targetFolder, $linkFolder]);
});
