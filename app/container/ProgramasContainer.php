<?php
namespace App\container;

class ProgramasContainer{

    static $programas
        = [
            ['id' => 1, 'nombre' => 'Programación'],
            ['id' => 2, 'nombre' => 'Videojuegos'],
            ['id' => 3, 'nombre' => 'Marketing']
        ];

    static function listar(){
        return self::$programas;
    }

    static function ver($i){
        return self::$programas[$i-1];
    }

    static function verNombreProID($id){
        $respuesta='error';
        foreach(self::$programas as $programa){
            if($programa['id']==$id)
                $respuesta=$programa['nombre'];
        }

        return $respuesta;
    }
}

?>
