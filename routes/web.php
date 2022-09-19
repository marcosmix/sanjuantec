<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\DifusionController;
use App\Http\Controllers\ContactoController;
Route::get('/generarCertificados/{curso_id}',[CertificadoController::class,'index'])->name('generarCertificados');
Route::post('/procesando',[CertificadoController::class,'generar'])->name('generarLectura');
Route::resource('cursos',CursosController::class);

Route::get('/difusion', [DifusionController::class, 'index'])->name('difusion.index');
Route::post('/importarContactos',[ContactoController::class, 'importarContactos'])->name('importarContactos');

Route::get('/enviarMails',[DifusionController::class,'enviarMails'])->name('enviarMail');

Route::get('/testearPDF',[CertificadoController::class, 'testearVistaPDF']);

Route::get('/', function () {
    return view('welcome');
});
