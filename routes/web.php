<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\DifusionController;
use App\Http\Controllers\ContactoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
    return view('certificados.index');
    });
    Route::resource('cursos',CursosController::class);
    //Menú 'Generar Certificados' ↓
    Route::get('/generarCertificados/{curso_id}',[CertificadoController::class,'index'])->name('generarCertificados');
    Route::post('/procesando',[CertificadoController::class,'generar'])->name('generarLectura');
    Route::post('/generarCertificadoEspeciales',[CertificadoController::class, 'generarCertificadoEspeciales'])->name('generarCertificadoEspeciales');
    Route::post('/generarCertificadoJam',[CertificadoController::class, 'generarCertificadoJam'])->name('generarCertificadoJam');
    // Menú 'Certificados' ↓
    Route::view('/certificados/index','certificados.index')->name('cursosInicio');
    Route::view('/certificados/especiales', 'certificados.certificadosEspecialesExcel')->name('certificadosEspecialesIndex');
    Route::get('/cetificadoJAM',function(){
        return view('certificados.certificadoJAM');
    });
    // Menú 'Difusión' ↓
    Route::get('/difusion', [DifusionController::class, 'index'])->name('difusion.index');
    Route::get('/difusionImportarAprobados', [DifusionController::class, 'CargarContactos'])->name('difusion.ImportarAprobados');
    Route::post('/emviarMailsAprobados', [DifusionController::class, 'EnviarCertificados'])->name('difusion.EnviarCertificados');
    Route::get('/enviarMails',[DifusionController::class,'enviarMails'])->name('enviarMail');
    Route::get('/EnviarMensaje',[DifusionController::class,'enviarMensaje'])->name('difusion.EnviarMensaje');
    Route::post('/EnviarMensaje',[DifusionController::class,'EnviarMensajePOST'])->name('difusion.EnviarMensajePOST');
    // Rutas a funcionalidades independientes ↓
    Route::post('/importarContactos',[ContactoController::class, 'importarContactos'])->name('importarContactos');

    Route::get('/testearPDF',[CertificadoController::class, 'testearVistaPDF']);

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


require __DIR__.'/auth.php';

