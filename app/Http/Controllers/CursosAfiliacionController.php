<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CursosAfiliacionController extends Controller
{
    public function __invoke()
    {
        return view('afiliados.cursos');
    }
}
