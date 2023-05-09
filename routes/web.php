<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\DifusionController;
use App\Http\Controllers\ContactoController;

Route::get('/', function () {
    return view('inicio');
});

Route::resource('cursos',CursosController::class);

Route::get('/generarCertificados/{curso_id}',[CertificadoController::class,'index'])->name('generarCertificados');
Route::post('/procesando',[CertificadoController::class,'generar'])->name('generarLectura');
Route::post('/generarCertificadoEspeciales',[CertificadoController::class, 'generarCertificadoEspeciales'])->name('generarCertificadoEspeciales');
Route::post('/generarCertificadoJam',[CertificadoController::class, 'generarCertificadoJam'])->name('generarCertificadoJam');

Route::view('/certificados/index','certificados.index')->name('cursosInicio');
Route::view('/ceftificados/especiales', 'certificados.certificadosEspecialesExcel')->name('certificadosEspecialesIndex');
Route::get('/cetificadoJAM',function(){
    return view('certificados.certificadoJAM');
});

Route::get('/difusion', [DifusionController::class, 'index'])->name('difusion.index');
Route::get('/difusionImportarAprobados', [DifusionController::class, 'CargarContactos'])->name('difusion.ImportarAprobados');
Route::post('/emviarMailsAprobados', [DifusionController::class, 'EnviarCertificados'])->name('difusion.EnviarCertificados');
Route::get('/enviarMails',[DifusionController::class,'enviarMails'])->name('enviarMail');
Route::get('/EnviarMensaje',[DifusionController::class,'enviarMensaje'])->name('difusion.EnviarMensaje');
Route::post('/EnviarMensaje',[DifusionController::class,'EnviarMensajePOST'])->name('difusion.EnviarMensajePOST');

Route::post('/importarContactos',[ContactoController::class, 'importarContactos'])->name('importarContactos');

Route::get('/testearPDF',[CertificadoController::class, 'testearVistaPDF']);
