<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CursatecMail extends Mailable
{
    use Queueable, SerializesModels;

    public $estudiante;
    public function __construct($estudiante){
        $this->estudiante= $estudiante;
    }

    public function build(){
        return $this->view('mail.Cursatec');
    }
}
