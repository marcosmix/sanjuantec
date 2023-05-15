<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    protected $table = 'roles';

    /**
    * Declara la relación entre los roles y los usuarios. Un rol puede tener varios usuarios.
    * @author Leandro Brizuela.
    */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
    * Este método obtiene el id del rol según el nombre del mismo.
    * @author Leandro Brizuela.
    * @param string $nombreRol
    * @return int $role_id Número entero que corresponde al id del rol.
    */
    public function determinarRolId ($nombreRol)
    {
        if ((!isset($nombreRol)) || (empty($nombreRol))) {
            exit('Error en: '.__FUNCTION__);
        }

       $role_id = Rol::where('rol', $nombreRol)
               ->value('id');

       return $role_id;
    }
}
