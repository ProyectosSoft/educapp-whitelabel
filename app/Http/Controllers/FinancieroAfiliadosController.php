<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinancieroAfiliadosController extends Controller
{
    public function __invoke()
    {
        return view('afiliados.financiero');
    }
}
