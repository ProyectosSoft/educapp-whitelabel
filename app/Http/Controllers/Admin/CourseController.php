<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use  App\Mail\CursosAprobados;
use  App\Mail\CursoRechazado;

class CourseController extends Controller
{
    public function index(){
        $courses = Curso::where('status',2)->paginate();
        return view('admin.cursos.index',compact('courses'));
    }

    public function show(Curso $course){

        $this->authorize('revision',$course);
        return view ('admin.cursos.show',compact('course'));
    }

    public function aprobado(Curso $course){
        $this->authorize('revision',$course);
        if (!$course->lecciones || !$course->Objetivo_curso || !$course->Requerimiento_curso || !$course->descripcion) {
            return back()->with('info','El curso no puede ser aprobado porque no tiene lecciones');
        }
        $course->status = 3;
        $course->save();

        // Envio de correo electronico
        $mail = new CursosAprobados($course);
        Mail::to($course->teacher->email)->queue($mail);
        return  redirect()->route('admin.cursos.index')->with('info','El curso se publicó con éxito');
    }

    public function observacion(Curso $course){
        return view('admin.cursos.observacion',compact('course'));
    }

    public function rechazado(Curso $course, Request $request){
        $this->authorize('revision',$course);
        $request->validate([
            'body' => 'required'
        ]);
        $course->observation()->create($request->all());
        $course->status = 1;
        $course->save();
        $mail = new CursoRechazado('Prueba Name',$course);
        Mail::to($course->teacher->email)->queue($mail);
        return  redirect()->route('admin.cursos.index')->with('info','El curso se rechazó con éxito');
    }
    public function noaprobado($course){
        $courses = Curso::where('status',1)->paginate();
        return view('admin.cursos.noaprobado',compact('courses'));
    }
}
