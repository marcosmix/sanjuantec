<?php

namespace App\Models;

use App\Models\Certificado;
use App\container\ProgramasContainer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Curso extends Model
{
    protected $guarded=[];
    use HasFactory;

    public function certificados()
    {
        return $this->hasMany(Certificado::class, 'id_curso', 'id');
    /**
     * Este método establece la relación "hasMany" entre el modelo actual y el modelo Certificado.
     * Indica que un objeto de este modelo tiene múltiples instancias de Certificado relacionadas
     * a través del campo 'id_curso'.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany La relación "hasMany" entre el modelo
     * actual y el modelo Certificado.
     */
    }

    public function programa()
    {
        return ProgramasContainer::ver($this->programa_id)['nombre'];
    }

    public static function validarYCrearCurso ($request)
    {
        $reglasValidacion = [
            'nombre' => 'required|string|max:120',
            'texto' => 'required|string|max:500',
            'duracion' => 'required|string|max:30',
            'fecha' => 'required|string|max:50',
            'bloque' => 'required|string|max:50',
        ];

        $validacion = Validator::make($request->all(), $reglasValidacion);

         if ($validacion->fails()) {
            $mensajeError = 'Los datos ingresados no son válidos:';
            foreach ($validacion->errors()->all() as $error) {
                $mensajeError .= ' ' . $error;
            }
            return ['errores_de_validacion' => $mensajeError];
        }

        $nuevoCurso = new Curso();
        $nuevoCurso->nombre = $request->nombre;
        $nuevoCurso->texto = $request->texto;
        $nuevoCurso->duracion = $request->duracion;
        $nuevoCurso->fecha = $request->fecha;
        $nuevoCurso->bloque = $request->bloque;
        $nuevoCurso->save();

        return $nuevoCurso;
    }
}
