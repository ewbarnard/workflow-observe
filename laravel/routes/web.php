<?php

declare(strict_types=1);

use App\Http\Controllers\BatchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\WorkflowController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('workflows', WorkflowController::class);

Route::resource('files', FileController::class)->only(['index', 'show']);

Route::resource('batches', BatchController::class)->only(['index', 'show']);
