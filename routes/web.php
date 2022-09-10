<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\CursosController;

Route::get('/generarCertificados/{curso_id}',[CertificadoController::class,'index'])->name('generarCertificados');
Route::post('/procesando',[CertificadoController::class,'generar'])->name('generarLectura');
Route::resource('cursos',CursosController::class);
Route::get('/', function () {
    return view('welcome');
});
