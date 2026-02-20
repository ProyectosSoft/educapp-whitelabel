<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SelectPerfilController;
use App\Http\Livewire\ShoppingCart;
use App\Http\Livewire\CreateOrder;
use App\Http\Livewire\CourseStatus;
use App\Http\Livewire\CourseStatusL;
use App\Http\Livewire\SelectProfile;
use App\Http\Controllers\WebhooksController;
use App\Http\Controllers\WebhookController;
use App\Models\Order;
use App\Http\Livewire\WishLists;
use App\Http\Livewire\Admin\Financiero;

Route::get('invite/{uuid}', [\App\Http\Controllers\InvitationController::class, 'accept'])->name('invite.accept');

Route::get('registro', function () {
    return view('auth.register');
})->middleware('guest')->name('registro');

Route::get('register-business', [\App\Http\Controllers\BusinessController::class, 'create'])->middleware('guest')->name('register-business');
Route::post('register-business', [\App\Http\Controllers\BusinessController::class, 'store'])->middleware('guest');


Route::get('search',SearchController::class)->name('search');
Route::get('/', HomeController::class)->name('home');
Route::get('cursos',[CursoController::class,'index'])->name('cursos.index');
Route::get('cursos/{course}',[CursoController::class,'show'])->name('cursos.show');
Route::post('cursos/{course}/matriculado',[CursoController::class,'matriculado'])->middleware('auth')->name('cursos.matriculado');
Route::post('cursos/{course}/solicitar-reembolso',[CursoController::class,'solicitarReembolso'])->name('cursos.solicitarReembolso');

Route::get('cursos-status/{course}',CourseStatus::class)->name('cursos.status')->middleware('auth');
Route::get('cursos-status-l/{course}/{leccionid}',CourseStatusL::class)->name('cursos.statusl')->middleware('auth');
Route::get('cursos/{course}/evaluation/{evaluation}', \App\Http\Livewire\Student\EvaluationPage::class)->name('courses.evaluation')->middleware('auth');
Route::get('certificates/{attempt}/download', [App\Http\Controllers\CertificationController::class, 'download'])->name('certificates.download')->middleware('auth');
Route::get('shopping-cart', ShoppingCart::class)->name('shopping-cart')->middleware('auth');
Route::get('perfil',SelectProfile::class)->name('perfil.index');
Route::post('webhook/github', [WebhookController::class, 'github']);
Route::get('webhook/github', [WebhookController::class, 'github']);
Route::get('wishlist',WishLists::class)->name('wishlist')->middleware('auth');

// Define la ruta para ver el reporte
Route::get('reporte/comprobante/{transactionNumber}', [ReporteController::class, 'verReporte'])->name('admin.dashboard.comprobante_de_pago');
Route::get('reporte/factura/{transactionNumber}', [ReporteController::class, 'verReporte_factura'])->name('documentosfinancieros.factura_venta');
Route::get('reporte/saldo_favor{transactionNumber}', [ReporteController::class, 'verReporte_saldofavor'])->name('documentosfinancieros.saldo_favor');
Route::get('reporte/devolucion/{transactionNumber}', [ReporteController::class, 'verReporte_devolucion'])->name('documentosfinancieros.devolucion');



Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('orders/create',CreateOrder::class)->name('orders.create');
    Route::get('orders/{order}',[OrderController::class,'show'])->name('orders.show');
    Route::get('orders/{order}/payment',[OrderController::class,'payment'])->name('orders.payment');
    Route::get('orders/{order}/pay',[OrderController::class,'pay'])->name('orders.pay');
    Route::post('webhooks',WebhooksController::class);
    Route::post('orders/{order}/zero-payment',[OrderController::class,'zeroPayment'])->name('orders.zeroPayment');
    Route::get('orders',[OrderController::class,'index'])->name('orders.index');
});

// Module Exams (Student)
Route::middleware(['auth'])->group(function () {
    Route::get('my-evaluations', \App\Http\Livewire\Student\MyEvaluations::class)->name('student.evaluations.index');
    Route::get('exams', \App\Http\Livewire\Exams\ExamIndex::class)->name('exams.index');
    Route::get('exams/{evaluation}/summary', \App\Http\Livewire\Exams\ExamSummary::class)->name('exams.summary');
    Route::get('exams/{evaluation}', \App\Http\Livewire\Exams\ExamTaker::class)->name('exams.taker');
    Route::get('exams/certificate/{attempt}', [\App\Http\Controllers\CertificationController::class, 'downloadExam'])->name('exams.certificate');
});
