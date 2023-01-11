<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\DifusionController;
use App\Http\Controllers\ContactoController;
Route::get('/generarCertificados/{curso_id}',[CertificadoController::class,'index'])->name('generarCertificados');
Route::post('/procesando',[CertificadoController::class,'generar'])->name('generarLectura');
Route::resource('cursos',CursosController::class);

Route::view('/certificados/index','certificados.index-certificados')->name('curos-inicio');
Route::post('/generarCertificadoEspeciales',[CertificadoController::class, 'generarCertificadoEspeciales'])->name('generarCertificadoEspeciales');

Route::view('/ceftificados/especiales', 'certificados.certificadosEspecialesExcel')->name('certificadosEspecialesIndex');
Route::get('/difusion', [DifusionController::class, 'index'])->name('difusion.index');
Route::get('/difusionImportarAprobados', [DifusionController::class, 'CargarContactos'])->name('difusion.ImportarAprobados');
Route::post('/emviarMailsAprobados', [DifusionController::class, 'EnviarCertificados'])->name('difusion.EnviarCertificados');

Route::get('/cetificadoJAM',function(){
    return view('certificados.certificadoJAM');
});
Route::post('/generarCertificadoJam',[CertificadoController::class, 'generarCertificadoJam'])->name('generarCertificadoJam');

Route::post('/importarContactos',[ContactoController::class, 'importarContactos'])->name('importarContactos');

Route::get('/enviarMails',[DifusionController::class,'enviarMails'])->name('enviarMail');

Route::get('/testearPDF',[CertificadoController::class, 'testearVistaPDF']);

Route::get('/', function () {
    return view('welcome');
});
