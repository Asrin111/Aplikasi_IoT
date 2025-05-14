<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;

Route::get('/', function () {
    return view('welcome');
});

//dashboard
Route::get('/dashboard', [DashboardController::class, 'IndexPage'])->name('dashboard');

//hapus project di dashboard
Route::delete('/project/{id}', [ProjectController::class, 'destroy'])->name('project.delete');

// Route untuk melihat detail project
Route::get('/project/{id}', [ProjectController::class, 'detail'])->name('project.detail');