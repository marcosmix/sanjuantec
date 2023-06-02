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

    // Menú Crear plantillas de cursos ↓
    Route::get('/plantillas', [CursosController::class, 'index'])->name('plantillas');
    Route::get('/plantillas/crear', [CursosController::class, 'crearPlantilla'])->name('crearPlantilla');
    Route::post('/plantillas/crear', [CursosController::class, 'guardarPlantilla'])->name('guardarPlantilla');
    Route::post('/plantillas/generar', [DifusionController::class, 'generarCertificados'])->name('generarCertificados');

    // Menú Generar certificados de cursos. ↓
    Route::get('/certificados/generar', [DifusionController::class, 'generarCertificadosPorCurso'])->name('generarCertificadosPorCurso');

    // Menú Generar otros certificados. ↓
    Route::get('/certificados/generarOtros', [CursosController::class, 'generarOtrosCertificados'])->name('generarOtrosCertificados');

    // Menú Administrar certificados de cursos
    Route::get('/certificados', [CertificadoController::class, 'administrarCertificados'])->name('administrarCertificados');

    // Menú 'Generar Certificados' ↓
    // TODO Ruta comentada para evitar conflictos con otra ruta definida con el mismo nombre. Al finalizar la implementación del
    // nuevo flujo de uso, es posible que sea eliminada o editada.
    //  Route::get('/generarCertificados/{curso_id}',[CertificadoController::class,'index'])->name('generarCertificados');
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

    // TODO Ruta provisoria para probar endpoint de Moodle.
    Route::get('/test_mostrarCursos', [CursosController::class, 'mostrarCursos']);//Obtiene los cursos en Moodle/CursaTec.
});

require __DIR__.'/auth.php';

