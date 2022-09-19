<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DifusionController extends Controller
{
    public function index(){
        return view('difusion.index');
    }

    public function enviarMails(){
        $subject="Marcos";
        $for= "madcmix14sj@gmail.com";
        Mail::send('difusion.email',['name'=>'San Juan Tec','msg'=>'Hola como estas'],
        function($msj) use($subject,$for){
            $msj->from('marcodesos@gmail.com',"Marcodeev");
            $msj->subject($subject);
            $msj->to($for);
        });
    }
}
