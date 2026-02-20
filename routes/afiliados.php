<?php

use App\Http\Controllers\CursosAfiliacionController;
use App\Http\Controllers\FinancieroAfiliadosController;
use App\Http\Controllers\HomeAfiliadoController;
use Illuminate\Support\Facades\Route;



Route::get('/',HomeAfiliadoController::class)->name('dashboard');
Route::get('cursos',CursosAfiliacionController::class)->name('cursos');
Route::get('financierio',FinancieroAfiliadosController::class)->name('financiero');
