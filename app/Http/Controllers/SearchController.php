<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curso;

class SearchController extends Controller
{
    public function __invoke(Request $request){

        $name = $request->name;

        $courses = Curso::where ('nombre','LIKE','%' . $name . '%')->where('status',3)->paginate(8);
        return view('search',compact('courses'));
    }
}
