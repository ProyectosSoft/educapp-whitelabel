<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Curso;
use Illuminate\Support\Facades\Auth;

class HomeAlumnController extends Controller
{
    public function __invoke()
    {
        return view('alumnos.dashboard');
    }
}
