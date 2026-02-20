<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinancieroAuthorController extends Controller
{
    public function __invoke()
    {
        return view('author.dashboard.financiero');
    }
}
