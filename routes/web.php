<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/excel', [ExcelController::class, 'index'])->name('excel.index'); // Форма для загрузки
Route::post('/excel/upload', [ExcelController::class, 'upload'])->name('excel.upload'); // Загрузка файла
