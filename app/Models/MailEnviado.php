<?php

namespace App\Models;

use App\Models\Alumno;
use App\Models\Certificado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailEnviado extends Model
{
    use HasFactory;
    protected $table = 'mails_enviados';
    protected $fillable = ['id_alumno', 'id_certificado', 'estado'];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'id_alumno', 'id');
    /**
     * Relación "belongsTo" con el modelo Alumno.
     * Indica que un objeto de este modelo pertenece a una instancia de la clase Alumno, utilizando el
     * campo 'id_alumno'como clave foránea en el modelo actual y el campo 'id' como clave primaria en el modelo Alumno.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo La relación "belongsTo" con el modelo Alumno.
     */
    }

    public function certificado ()
    {
        return $this->belongsTo(Certificado::class, 'id_certificado', 'id');
    /**
     * Relación "belongsTo" con el modelo Certificado.
     * Indica que un objeto de este modelo pertenece a una instancia de la clase Certificado, utilizando el campo
     * 'id_certificado' como clave foránea en el modelo actual y el campo 'id' como clave primaria en el modelo Certificado.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo La relación "belongsTo" con el modelo Certificado.
     */
    }

    public function guardarEmailEnviado ($documentoAlumno, $idCurso)
    {
        $idAlumno = Alumno::obtenerIdAlumnoPorDocumento($documentoAlumno);
        $idCertificado = Certificado::obtenerIdCertificado($idAlumno, $idCurso);

        if ($idCertificado) {
            $this->create([
                'id_alumno' => $idAlumno,
                'id_certificado' => $idCertificado,
                'estado' => true,
            ]);
            return true;
        } else {
        // TODO BEGIN Puede ser válido no guardar el registro del email si no se obtuvo un id de certificado.
        // Dicho escenario puede significar que algo salió mal. END
            $this->create([
                'id_alumno' => $idAlumno,
                'id_certificado' => $idCertificado,
                'estado' => false,
            ]);
            return false;
        }
    }
}
