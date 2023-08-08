<?php
namespace App\Helpers;

use Psy\CodeCleaner\FunctionContextPass;
use App\Mail\CertificadosMail;
use Illuminate\Support\Facades\Mail;
use SebastianBergmann\Timer\Duration;
use App\Mail\CursatecMail;

class MailTec
{
    static function EnviarMailCertificados($estudiante, $curso, $mensajes)
    {
        $email = $estudiante->email;

        return Mail::to($email)->send(
            new CertificadosMail($estudiante, $curso, $mensajes)
        );
    }

    static function EnviarCuentasCursatec($estudiante)
    {
        Mail::to($estudiante["email"])->send(new CursatecMail($estudiante));
    }
}

?>
