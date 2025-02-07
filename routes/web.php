<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\ScriptController;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('/procedures')->group(function () {
        Route::get('/', [ProcedureController::class, 'index'])->name('procedures');
        Route::post('/', [ProcedureController::class, 'store'])->name('procedures.store');
    });

    Route::prefix('/script')->group(function () {
        Route::get('/', [ScriptController::class, 'index'])->name('script');
        Route::post('/', [ScriptController::class, 'store'])->name('script.store');
    });


    Route::prefix('groups')->group(function () {
        Route::get('/list', [GroupController::class, 'myGroups'])->name('group.list');

        Route::middleware(RoleMiddleware::class . ':admin')->group(function () {
            Route::get('/', [GroupController::class, 'index'])->name('group');
            Route::get('/create', [GroupController::class, 'create'])->name('group.create');
            Route::post('/', [GroupController::class, 'store'])->name('group.store');

            Route::prefix('/files')->group(function () {
                Route::post('/upload', [FileController::class, 'upload'])->name('files.upload');
                Route::delete('/delete', [FileController::class, 'delete'])->name('files.delete');
            });


            Route::prefix('/{group}')->group(function () {
                Route::get('/', [GroupController::class, 'show'])->name('group.show');
                Route::get('/edit', [GroupController::class, 'edit'])->name('group.edit');
                Route::put('/', [GroupController::class, 'update'])->name('group.update');
                Route::put('/', [GroupController::class, 'delete'])->name('group.delete');
                Route::get('/add-members', [GroupController::class, 'addMembersForm'])->name('group.add_members');
                Route::post('/add-members', [GroupController::class, 'addMembers'])->name('group.store_members');
                Route::delete('/members/{user}', [GroupController::class, 'removeMember'])->name('group.remove_member');
            });

        });
    });

    Route::prefix('admin')->group(function () {
        Route::middleware(RoleMiddleware::class . ':admin')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('admin');

            Route::get('/followup', [FollowUpController::class, 'index'])->name('followup');


            Route::prefix('/users')->group(function () {
                Route::get('/', [AdminController::class, 'users'])->name('admin.users');
                Route::get('/create/new', [AdminController::class, 'usersCreate'])->name('admin.user.create');
                Route::get('/{user}/edit', [AdminController::class, 'usersEdit'])->name('admin.user.edit');
                Route::put('/{user}', [AdminController::class, 'usersUpdate'])->name('admin.user.update');
                Route::get('/{user}', [AdminController::class, 'userShow'])->name('admin.user.show'); //TODO нужно дорабоать есть ошибка

                Route::post('/', [AdminController::class, 'usersStore'])->name('admin.user.store');
            });
        });
    });

    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/tasks/{task}/assign', [TaskController::class, 'assignToMe'])->name('tasks.assign');
    Route::post('/tasks/{task}/unassign', [TaskController::class, 'unassignFromMe'])->name('tasks.unassign');
    Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])->name('comments.store');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/excel', [ExcelController::class, 'index'])->name('excel.index'); // Форма для загрузки
Route::post('/excel/upload', [ExcelController::class, 'upload'])->name('excel.upload'); // Загрузка файла


