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

    public function crearOActualizarCertificado ($alumnoId, $directorio)
    {
        $id = Str::random(5);

        $accionFinal = "N/A";

        if (empty($alumnoId)) {
            return false;
        }

        $certificado = [
            'id' => $id,
            'id_alumno' => $alumnoId,
            'directorio' => $directorio
        ];

        try {
            // Intentar encontrar el registro por 'id_alumno'. Actualizar registro.
            $certificadoExistente = self::where('id_alumno', $alumnoId)->firstOrFail();
            $certificadoExistente->update($certificado);
            $accionFinal = "Registro actualizado.";
        } catch (ModelNotFoundException $exception) {
            // No se encontró ningún registro con el número de 'documento'. Se creará un nuevo registro.
            self::create($certificado);
            $accionFinal = "Nuevo registro creado.";
        }
    }

    public function crearOActualizarCertificados ($certificados)
    {
        DB::beginTransaction();

        try {
            foreach ($certificados as $certificado) {
                $id = Str::random(5);
                $idAlumno = $certificado['idAlumno'];
                $directorioCompleto = $certificado['directorioCompleto'];

                Certificado::updateOrCreate(['id_alumno' => $idAlumno],
                                            ['id' => $id, 'directorio' => $directorioCompleto]
               );
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
