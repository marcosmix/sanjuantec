<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\container\ProgramasContainer;

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
}
