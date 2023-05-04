<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;

class CursatecImportFULL implements ToCollection
{
    use Importable;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        return new ([
            'user'=>$collection[0],
            'pass'=>$collection[1],
            'email'=>$collection[2],
            'nombre'=>$collection[3],
            'apellido'=>$collection[4],
            'curso'=>$collection[5],
        ]);
    }
}
