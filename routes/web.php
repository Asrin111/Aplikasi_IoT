<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;

Route::get('/', function () {
    return view('welcome');
});

//dashboard
Route::get('/dashboard', [DashboardController::class, 'IndexPage'])->name('dashboard');

// Route untuk melihat detail project
// Route::get('/project/1', [ProjectController::class, 'detail'])->name('project.detail');