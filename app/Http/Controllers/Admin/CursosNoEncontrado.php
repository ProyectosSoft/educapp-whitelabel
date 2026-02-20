<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CursosNoEncontrado extends Controller
{
    public function index(){
        return view('admin.cursos.noaprobado');
    }
}
