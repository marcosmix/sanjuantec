<?php

use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\DifusionController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;
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

    // Menú Crear plantillas de cursos. ↓
    Route::get('/plantillas', [CursosController::class, 'index'])->name('plantillas');
    Route::get('/plantillas/crear', [CursosController::class, 'crearPlantilla'])->name('crearPlantilla');
    Route::post('/plantillas/crear', [CursosController::class, 'guardarPlantilla'])->name('guardarPlantilla');
    Route::post('/plantillas/generar', [DifusionController::class, 'prepararEnvioCertificados'])->name('prepararEnvioCertificados');
    Route::post('/plantillas//procesarEnvio', [DifusionController::class, 'enviarCertificados'])->name('enviarCertificados');

    // Menú Generar certificados de cursos. ↓
    Route::get('/certificados/generar', [DifusionController::class, 'generarCertificadosPorCurso'])->name('generarCertificadosPorCurso');

    // Menú Generar otros certificados. ↓
    Route::get('/certificados/generarOtros', [CursosController::class, 'generarOtrosCertificados'])->name('generarOtrosCertificados');
    Route::post('/certificados/crearOtros', [CursosController::class, 'guardarPlantillaYCertificados'])->name('guardarPlantillaYCertificados');

    // Menú Generar un certificado de un/a alumno/a. ↓
    Route::get('/certificado/alumno', [DifusionController::class, 'generarCertificadoPorAlumno'])->name('generarCertificadoPorAlumno');
    Route::post('/certificado/crear', [DifusionController::class, 'enviarCertificadoPorAlumno'])->name('enviarCertificadoPorAlumno');

    // Menú Administrar certificados de cursos. ↓
    Route::get('/certificados/administrar', [CertificadoController::class, 'administrarCertificados'])->name('administrarCertificados');
    Route::post('/certificados/enviarCertificados', [DifusionController::class, 'enviarCertificadoPorMetodoAjax'])->name('enviarCertificadoPorMetodoAjax');
    Route::post('/certificados/enviarTodosLosCertificados', [DifusionController::class, 'enviarTodosLosCertificadosPorAjax'])->name('enviarTodosLosCertificadosPorAjax');

    // Ruta al controlador del método para visualizar un archivo PDF. ↓
    Route::get('/mostrarPdf/{documento}/{nombreCurso}', [PdfController::class, 'mostrarPdf'])->name('mostrarPdf');

    /**
     * A partir de aquí, están definidas las rutas que deberán ser revisadas para ser refactorizadas, descartadas o simplemente utilizadas.
     * @author Leandro Brizuela
     * @date 02 de junio de 2023
     */

    // Menú 'Generar Certificados'. ↓
    Route::get('/generarCertificados/{curso_id}',[CertificadoController::class,'index'])->name('generarCertificados');
    Route::post('/procesando',[CertificadoController::class,'generar'])->name('generarLectura');
    Route::post('/generarCertificadoEspeciales',[CertificadoController::class, 'generarCertificadoEspeciales'])->name('generarCertificadoEspeciales');
    Route::post('/generarCertificadoJam',[CertificadoController::class, 'generarCertificadoJam'])->name('generarCertificadoJam');

    // Menú 'Certificados'. ↓
    Route::view('/certificados/index','certificados.index')->name('cursosInicio');
    Route::view('/certificados/especiales', 'certificados.certificadosEspecialesExcel')->name('certificadosEspecialesIndex');
    Route::get('/cetificadoJAM',function(){
        return view('certificados.certificadoJAM');
    });

    // Menú 'Difusión'. ↓
    Route::get('/difusion', [DifusionController::class, 'index'])->name('difusion.index');
    Route::get('/enviarMails',[DifusionController::class,'enviarMails'])->name('enviarMail');
    Route::get('/EnviarMensaje',[DifusionController::class,'enviarMensaje'])->name('difusion.EnviarMensaje');
    Route::post('/EnviarMensaje',[DifusionController::class,'EnviarMensajePOST'])->name('difusion.EnviarMensajePOST');

    // Rutas a funcionalidades independientes. ↓
    Route::post('/importarContactos',[ContactoController::class, 'importarContactos'])->name('importarContactos');
    Route::get('/testearPDF',[CertificadoController::class, 'testearVistaPDF']);

    // Ruta predeterminada del dashboard/panel de Breeze-Blade.
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // TODO Ruta provisoria para probar endpoint de Moodle.
    Route::get('/test_mostrarCursos', [CursosController::class, 'mostrarCursos']);//Obtiene los cursos en Moodle/CursaTec.
});

require __DIR__.'/auth.php';

