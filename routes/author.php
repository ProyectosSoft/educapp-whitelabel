<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Author\CursosController;
use App\Http\Controllers\FinancieroAuthorController;
use App\Http\Livewire\Author\CursosCurriculum;
use App\Http\Livewire\Author\CursosEstudiantes;
use App\Http\Livewire\Author\CursosCupones;
use App\Http\Livewire\Author\CursosLinkReferral;
use App\Http\Livewire\Author\CursosPrices;
use App\Http\Controllers\Author\PriceController;

Route::redirect('','author/courses');
Route::resource('cursos',CursosController::class)->names('cursos');
Route::post('prices', [PriceController::class, 'store'])->name('prices.store');
Route::get('cursos/{course}/curriculum',CursosCurriculum::class)->middleware('can:Actualizar cursos')->name('cursos.curriculum');
Route::get('cursos/{course}/objetivos',[CursosController::class,'objetivos'])->name('cursos.objetivos');
Route::get('cursos/{course}/estudiantes',CursosEstudiantes::class)->middleware('can:Actualizar cursos')->name('cursos.estudiantes');
Route::get('cursos/{course}/cupones',CursosCupones::class)->name('cursos.cupones');
Route::get('cursos/{course}/linkreferral',CursosLinkReferral::class)->name('cursos.linkreferral');
Route::post('cursos/{course}/status',[CursosController::class,'status'])->name('cursos.status');
Route::get('cursos/{course}/observacion',[CursosController::class,'observacion'])->name('cursos.observacion');
Route::get('cursos/{course}/image',[CursosController::class,'image'])->name('cursos.image');
Route::get('cursos/{course}/precios',CursosPrices::class)->name('cursos.precios');
Route::get('cursos/{course}/final-exam',[CursosController::class,'finalExam'])->name('cursos.final-exam');
Route::get('financiero', FinancieroAuthorController::class)->name('financiero');

// Exams Management (Author)
// Exams Management (Author)
Route::group(['middleware' => ['can:Ver dashboard examenes']], function () {
    Route::get('exams', \App\Http\Livewire\Exams\ExamManager::class)->name('exams.manager');
    Route::get('exams/global-statistics', \App\Http\Livewire\Exams\GlobalStats::class)->name('exams.global-stats');
    Route::get('exams/question-bank', \App\Http\Livewire\Exams\QuestionBank::class)->name('exams.question-bank');
    Route::get('exams/difficulty-levels', \App\Http\Livewire\Exams\DifficultyManager::class)->name('exams.difficulty-levels');
    Route::get('exams/{evaluation}/builder', \App\Http\Livewire\Exams\EvaluationBuilder::class)->name('exams.builder');
    Route::get('exams/{evaluation}/monitoring', \App\Http\Livewire\Exams\ExamMonitoring::class)->name('exams.monitoring');
    Route::get('exams/{evaluation}/statistics', \App\Http\Livewire\Exams\ExamStatistics::class)->name('exams.statistics');
    Route::get('exams/grading', \App\Http\Livewire\Exams\ExamGrader::class)->name('exams.grader');
});
