<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(RoleMiddleware::class . ':admin')->group(function () {
        Route::get('/groups', [GroupController::class, 'index'])->name('group');
        Route::get('/groups/create', [GroupController::class, 'create'])->name('group.create');
        Route::post('/groups', [GroupController::class, 'store'])->name('group.store');
        Route::get('/groups/{group}', [GroupController::class, 'show'])->name('group.show');
        Route::get('/groups/{group}/edit', [GroupController::class, 'edit'])->name('group.edit');
        Route::put('/groups/{group}', [GroupController::class, 'update'])->name('group.update');
        Route::put('/groups/{group}', [GroupController::class, 'delete'])->name('group.delete');
        Route::get('/groups/{group}/add-members', [GroupController::class, 'addMembersForm'])->name('group.add_members');
        Route::post('/groups/{group}/add-members', [GroupController::class, 'addMembers'])->name('group.store_members');
        Route::delete('/groups/{group}/members/{user}', [GroupController::class, 'removeMember'])->name('group.remove_member');

    });


    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/excel', [ExcelController::class, 'index'])->name('excel.index'); // Форма для загрузки
Route::post('/excel/upload', [ExcelController::class, 'upload'])->name('excel.upload'); // Загрузка файла


