<?php

namespace App\Models;

use App\Models\Alumno;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Certificado extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_alumno',
        'id_curso',
        'directorio'
    ];

    public function alumno ()
    {
        return $this->belongsTo(Alumno::class, 'id_alumno');
    /**
     * Este método establece la relación "belongsTo" entre el modelo actual y el modelo Alumno.
     * Indica que un objeto de este modelo pertenece a una instancia de Alumno relacionada a través
     * del campo 'id_alumno'.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo La relación "belongsTo" entre el
     * modelo actual y el modelo Alumno.
     */
    }

    public function mailEnviado ()
    {
        return $this->hasOne(MailEnviado::class, 'id_certificado', 'id');
    /**
     * Relación "hasOne" con el modelo MailEnviado.
     * Indica que un objeto de este modelo tiene una instancia asociada de la clase MailEnviado, utilizando
     * el campo 'id_certificado' como clave foránea en el modelo MailEnviado y el campo 'id' como clave primaria
     * en el modelo actual.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne La relación "hasOne" con el modelo MailEnviado.
     */
    }

    public function curso ()
    {
        return $this->belongsTo(Curso::class, 'id_curso', 'id');
    /**
     * Este método establece la relación "belongsTo" entre el modelo actual y el modelo Curso.
     * Indica que un objeto de este modelo pertenece a una instancia de Curso relacionada a través
     * del campo 'id_curso'.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo La relación "belongsTo" entre el
     * modelo actual y el modelo Curso.
     */
    }

    public function crearOActualizarCertificados ($certificados, $idCurso)
    {
        DB::beginTransaction();

        try {
            foreach ($certificados as $certificado) {
                $idAlumno = $certificado['idAlumno'];
                $directorioCompleto = $certificado['directorioCompleto'];

                $certificadoExistente = Certificado::where('id_alumno', $idAlumno)
                                          ->where('id_curso', $idCurso)
                                          ->first();

                if ($certificadoExistente) {
                    $certificadoExistente->update([
                        'directorio' => $directorioCompleto,
                        'id_curso' => $idCurso
                    ]);
                } else {
                    $id = Str::random(5);

                    Certificado::create([
                        'id' => $id,
                        'id_alumno' => $idAlumno,
                        'directorio' => $directorioCompleto,
                        'id_curso' => $idCurso
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    /**
     * Crea o actualiza certificados para los alumnos asociados a un curso dado.
     *
     * Este método realiza una transacción en la base de datos para asegurar la consistencia de los datos.
     * Recibe una matriz de certificados y el ID del curso al que pertenecen los alumnos.
     * Por cada certificado en la matriz, verifica si el alumno ya tiene un certificado existente.
     * Si el certificado existe, actualiza la información del directorio y el ID del curso asociado.
     * Si el certificado no existe, crea uno nuevo con un ID generado aleatoriamente.
     *
     * @param array $certificados Una matriz de certificados que contiene la información de los alumnos y su directorio.
     *                           Cada elemento de la matriz tiene las siguientes propiedades:
     *                           - 'idAlumno': El ID del alumno asociado al certificado.
     *                           - 'directorioCompleto': El directorio completo donde se encuentra el certificado.
     * @param int $idCurso El ID del curso al que pertenecen los alumnos asociados a los certificados.
     * @return void
     *
     * @throws \Exception Si ocurre algún error durante la transacción en la base de datos.
     */
    }


    public static function obtenerIdCertificado($idAlumno, $idCurso)
    {
        $idCertificado = DB::table('certificados')
            ->where('id_alumno', $idAlumno)
            ->where('id_curso', $idCurso)
            ->value('id');

        return $idCertificado;
    }
}
