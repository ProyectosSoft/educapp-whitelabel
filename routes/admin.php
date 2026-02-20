<?php

use App\Http\Controllers\Admin\CategoriaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CursosNoEncontrado;
use App\Http\Controllers\FinancieroAdminController;
use App\Http\Livewire\Admin\Financiero;

Route::get('',[HomeController::class,'index'])->middleware('can:Ver dashboard')->name('home');

Route::resource('roles',RoleController::class)->names('roles')->middleware('can:Listar role');
Route::resource('users',UserController::class)->only(['index','edit','update'])->names('users')->middleware('can:Leer usuarios');

Route::get('cursos',[CourseController::class,'index'])->name('cursos.index')->middleware('can:Leer cursos');
Route::resource('categorias',CategoriaController::class)->names('categorias')->middleware('can:Leer categorias');
Route::resource('subcategorias',\App\Http\Controllers\Admin\SubcategoriaController::class)->names('subcategorias')->middleware('can:Leer subcategorias');
// Route::resource('empresas',\App\Http\Controllers\Admin\EmpresaController::class)->names('empresas')->middleware('can:Leer empresas');
Route::get('empresas', [\App\Http\Controllers\Admin\EmpresaController::class, 'index'])->name('empresas.index')->middleware('can:Leer empresas');
Route::get('empresas/create', [\App\Http\Controllers\Admin\EmpresaController::class, 'create'])->name('empresas.create')->middleware('can:Leer empresas');
Route::post('empresas', [\App\Http\Controllers\Admin\EmpresaController::class, 'store'])->name('empresas.store')->middleware('can:Leer empresas');
Route::delete('empresas/{empresa}', [\App\Http\Controllers\Admin\EmpresaController::class, 'destroy'])->name('empresas.destroy')->middleware('can:Leer empresas');

// Allow edit/update/show based on Policy, not just 'Leer empresas' permission
Route::get('empresas/{empresa}/edit', [\App\Http\Controllers\Admin\EmpresaController::class, 'edit'])->name('empresas.edit');
Route::put('empresas/{empresa}', [\App\Http\Controllers\Admin\EmpresaController::class, 'update'])->name('empresas.update');
Route::get('empresas/{empresa}', [\App\Http\Controllers\Admin\EmpresaController::class, 'show'])->name('empresas.show');

// Company Management Routes (for Company Admins)
Route::prefix('mi-empresa')->name('empresas.')->group(function () {
    Route::get('cursos', [\App\Http\Controllers\Admin\EmpresaController::class, 'cursosIndex'])->name('cursos.index');
    Route::get('instructores', [\App\Http\Controllers\Admin\EmpresaController::class, 'instructoresIndex'])->name('instructores.index');
    Route::get('alumnos', [\App\Http\Controllers\Admin\EmpresaController::class, 'alumnosIndex'])->name('alumnos.index');
    Route::get('certificaciones', [\App\Http\Controllers\Admin\EmpresaController::class, 'certificacionesIndex'])->name('certificaciones.index');

    // Categorias Management
    Route::get('categorias', [\App\Http\Controllers\Admin\EmpresaController::class, 'categoriasIndex'])->name('categorias.index');
    Route::post('categorias', [\App\Http\Controllers\Admin\EmpresaController::class, 'categoriasStore'])->name('categorias.store');
    Route::put('categorias/{categoria}', [\App\Http\Controllers\Admin\EmpresaController::class, 'categoriasUpdate'])->name('categorias.update');
    Route::delete('categorias/{categoria}', [\App\Http\Controllers\Admin\EmpresaController::class, 'categoriasDestroy'])->name('categorias.destroy');

    // Subcategorias Management
    Route::get('subcategorias', [\App\Http\Controllers\Admin\EmpresaController::class, 'subcategoriasIndex'])->name('subcategorias.index');
    Route::post('subcategorias', [\App\Http\Controllers\Admin\EmpresaController::class, 'subcategoriasStore'])->name('subcategorias.store');
    Route::put('subcategorias/{subcategoria}', [\App\Http\Controllers\Admin\EmpresaController::class, 'subcategoriasUpdate'])->name('subcategorias.update');
    Route::delete('subcategorias/{subcategoria}', [\App\Http\Controllers\Admin\EmpresaController::class, 'subcategoriasDestroy'])->name('subcategorias.destroy');
});
// Route::resource('departamentos',\App\Http\Controllers\Admin\DepartamentoController::class)->names('departamentos')->middleware('can:Leer departamentos');
Route::get('departamentos', [\App\Http\Controllers\Admin\DepartamentoController::class, 'index'])->name('departamentos.index')->middleware('can:Leer departamentos');
Route::get('departamentos/create', [\App\Http\Controllers\Admin\DepartamentoController::class, 'create'])->name('departamentos.create')->middleware('can:Leer departamentos');
Route::post('departamentos', [\App\Http\Controllers\Admin\DepartamentoController::class, 'store'])->name('departamentos.store');
Route::get('departamentos/{departamento}/edit', [\App\Http\Controllers\Admin\DepartamentoController::class, 'edit'])->name('departamentos.edit');
Route::put('departamentos/{departamento}', [\App\Http\Controllers\Admin\DepartamentoController::class, 'update'])->name('departamentos.update');
Route::delete('departamentos/{departamento}', [\App\Http\Controllers\Admin\DepartamentoController::class, 'destroy'])->name('departamentos.destroy');
Route::get('departamentos/{departamento}', [\App\Http\Controllers\Admin\DepartamentoController::class, 'show'])->name('departamentos.show');

Route::get('cursos/{course}',[CourseController::class,'show'])->name('cursos.show')->middleware('can:Leer cursos');
Route::post('cursos/{course}/aprobado',[CourseController::class,'aprobado'])->name('cursos.aprobado')->middleware('can:Actualizar cursos');
Route::get('cursos/{course}/observacion',[CourseController::class,'observacion'])->name('cursos.observacion')->middleware('can:Leer cursos');
Route::post('cursos/{course}/rechazado',[CourseController::class,'rechazado'])->name('cursos.rechazado')->middleware('can:Actualizar cursos');
Route::get('cursos/{course}/noaprobado',[CourseController::class,'noaprobado'])->name('cursos.noaprobado')->middleware('can:Actualizar cursos');

Route::get('financiero',FinancieroAdminController::class)->name('financiero')->middleware('can:Ver financiero admin');
Route::get('financiero/reporte',Financiero::class,'verReporte')->name('admin.dashboard.comprobante_de_pago')->middleware('can:Ver financiero admin');
Route::get('settings', \App\Http\Livewire\Admin\Settings::class)->name('settings')->middleware('can:Ver configuracion');
Route::get('auditoria', \App\Http\Livewire\Admin\AuditLog::class)->middleware('can:Ver auditoria')->name('audits.index');
Route::get('auditoria-cursos', \App\Http\Livewire\Admin\CourseAudits::class)->middleware('can:Ver auditoria')->name('audits.courses');
