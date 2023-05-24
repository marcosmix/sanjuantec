<?php

namespace App\Exceptions;

use Exception;

class MoodleRequestException extends Exception
{
    public function __construct($mensaje = "", $codigo = 0, Throwable $previo = null)
    {
        parent::__construct($mensaje, $codigo, $previo);
    }
}
