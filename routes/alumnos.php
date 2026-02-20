<?php

use App\Http\Controllers\FinancieroAlumnoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeAlumnController;


Route::get('/', HomeAlumnController::class)->name('dashboard');
Route::get('financiero', FinancieroAlumnoController::class)->name('financiero');
