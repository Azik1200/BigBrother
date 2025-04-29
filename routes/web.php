<?php

use App\Http\Controllers\{
    AdminController,
    AuthController,
    CommentController,
    DashboardController,
    ExcelController,
    FileController,
    FollowUpController,
    GroupController,
    NldController,
    ProcedureController,
    ScriptController,
    TaskController
};
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

// Public routes (no auth)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/excel', [ExcelController::class, 'index'])->name('excel.index');
Route::post('/excel/upload', [ExcelController::class, 'upload'])->name('excel.upload');

// Authenticated routes
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // NLD
    Route::prefix('nld')->name('nld.')->group(function () {
        Route::get('/', [NldController::class, 'index'])->name('index');
        Route::get('/create', [NldController::class, 'create'])->name('create');
        Route::post('/store', [NldController::class, 'store'])->name('store');
        Route::get('/show/{nld}', [NldController::class, 'show'])->name('show');
        Route::get('/edit/{nld}', [NldController::class, 'edit'])->name('edit');
        Route::put('/update/{nld}', [NldController::class, 'update'])->name('update');
        Route::put('/{nld}/done', [NldController::class, 'done'])->name('done');
        Route::delete('/delete/{nld}', [NldController::class, 'destroy'])->name('destroy');
        Route::post('/{nld}/comments', [CommentController::class, 'store'])->name('comments.store');
    });

    // Tasks
    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::get('/create', [TaskController::class, 'create'])->name('create');
        Route::post('/', [TaskController::class, 'store'])->name('store');
        Route::get('/{task}', [TaskController::class, 'show'])->name('show');
        Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('edit');
        Route::put('/{task}', [TaskController::class, 'update'])->name('update');
        Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
        Route::post('/{task}/assign', [TaskController::class, 'assignToMe'])->name('assign');
        Route::post('/{task}/unassign', [TaskController::class, 'unassignFromMe'])->name('unassign');
    });

    // Procedures
    Route::prefix('procedures')->name('procedures.')->group(function () {
        Route::get('/', [ProcedureController::class, 'index'])->name('index');
        Route::post('/', [ProcedureController::class, 'store'])->name('store');
    });

    // Scripts
    Route::prefix('script')->name('script.')->group(function () {
        Route::get('/', [ScriptController::class, 'index'])->name('index');
        Route::post('/', [ScriptController::class, 'store'])->name('store');
    });

    // Groups (open part)
    Route::prefix('groups')->name('group.')->group(function () {
        Route::get('/list', [GroupController::class, 'myGroups'])->name('list');

        // Groups (admin only)
        Route::middleware(RoleMiddleware::class . ':admin')->group(function () {
            Route::get('/', [GroupController::class, 'index'])->name('index');
            Route::get('/create', [GroupController::class, 'create'])->name('create');
            Route::post('/', [GroupController::class, 'store'])->name('store');

            Route::prefix('files')->name('files.')->group(function () {
                Route::post('/upload', [FileController::class, 'upload'])->name('upload');
                Route::delete('/delete', [FileController::class, 'delete'])->name('delete');
            });

            Route::prefix('{group}')->group(function () {
                Route::get('/', [GroupController::class, 'show'])->name('show');
                Route::get('/edit', [GroupController::class, 'edit'])->name('edit');
                Route::put('/', [GroupController::class, 'update'])->name('update');
                Route::put('/delete', [GroupController::class, 'delete'])->name('delete');
                Route::get('/add-members', [GroupController::class, 'addMembersForm'])->name('add_members');
                Route::post('/add-members', [GroupController::class, 'addMembers'])->name('store_members');
                Route::delete('/members/{user}', [GroupController::class, 'removeMember'])->name('remove_member');
            });
        });
    });

    // Admin
    Route::prefix('admin')->middleware(RoleMiddleware::class . ':admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/followup', [FollowUpController::class, 'index'])->name('followup');

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [AdminController::class, 'users'])->name('index');
            Route::get('/create/new', [AdminController::class, 'usersCreate'])->name('create');
            Route::post('/', [AdminController::class, 'usersStore'])->name('store');
            Route::get('/{user}', [AdminController::class, 'userShow'])->name('show');
            Route::get('/{user}/edit', [AdminController::class, 'usersEdit'])->name('edit');
            Route::put('/{user}', [AdminController::class, 'usersUpdate'])->name('update');
        });
    });
});
