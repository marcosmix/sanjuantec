<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ContactosImport;
use Maatwebsite\Excel\Facades\Excel;

class ContactoController extends Controller
{
    public function importarContactos(Request $request){
        Excel::import(new ContactosImport, request()->file('contactos') );
        return redirect(route('difusion.index'));
    }
}
