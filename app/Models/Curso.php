<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\container\ProgramasContainer;

class Curso extends Model
{
    protected $guarded=[];
    use HasFactory;

    public function programa(){
      
        return ProgramasContainer::ver($this->programa_id)['nombre'];
    }
}
