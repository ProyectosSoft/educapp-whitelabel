<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Categoria;
use App\Models\Nivel;
use App\Models\Precio;
use App\Models\Price;
use App\Models\Garantia;
use App\Models\Tipo_formato;
use App\Models\Moneda;
use App\Models\Empresa;
use App\Models\Departamento;
use Illuminate\Support\Facades\Storage;
use Dotenv\Util\Str;

class CursosController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Leer cursos')->only('index');
        $this->middleware('can:Crear cursos')->only('create', 'store');
        $this->middleware('can:Actualizar cursos')->only('edit', 'update', 'objetivos');
        $this->middleware('can:Eliminar cursos')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('author.cursos.index');
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Busca el usuario activo
        $idUsuario = auth()->user()->id;
        $categorias = Categoria::pluck('nombre', 'id');
        $niveles = Nivel::pluck('nombre', 'id');
        $precios = Price::where('user_id', $idUsuario)
        ->pluck('nombre', 'id');
        // $precios = Precio::pluck('nombre','id');
        $garantias = Garantia::pluck('nombre', 'id');
        $tipo_formatos = Tipo_formato::pluck('nombre', 'id');
        $monedas = Moneda::select('id', 'nombre', 'abreviatura')->where('estado', 1)->get();
        
        $empresas = Empresa::pluck('nombre', 'id');
        $allDepartamentos = Departamento::select('id', 'nombre', 'empresa_id')->get();

        return view('author.cursos.create', compact('categorias', 'niveles', 'precios', 'garantias', 'tipo_formatos', 'monedas', 'empresas', 'allDepartamentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'slug' => 'required|unique:cursos',
            'subtitulo' => 'required',
            'descripcion' => 'required',
            'categoria_id' => 'required',
            'nivel_id' => 'required',
            'precio_id' => 'required',
            'file' => 'image',
            'empresa_id' => 'nullable|exists:empresas,id',
            'departamento_id' => 'nullable|exists:departamentos,id',
        ]);

        $data = $request->all();
        $data['is_public'] = $request->has('is_public'); // Checkbox handling
        $data['precio_id'] = $request->precio_id; 
        
        // Si es público, limpiar empresa y depto aunque vengan
        if ($data['is_public']) {
            $data['empresa_id'] = null;
            $data['departamento_id'] = null;
        }

        $course = Curso::create($data);

        if ($request->file('file')) {

            $url = Storage::put('cursos', $request->file('file'));

            $course->image()->create([
                'url' => $url
            ]);
        }

        //Validar que el curso esté lleno logic (mantenida)
        if ($course) {
            $courseId = $course->id;
            $pricesc = Price::find($request->precio_id);
            if ($pricesc) {
                 Precio::create([
                    'nombre' => $pricesc->nombre,
                    'valor'  => $pricesc->valor,
                    'dctoMax' => $pricesc->dctoMax,
                    'dctoMin' => $pricesc->dctoMin,
                    'estado' => $pricesc->estado,
                    'moneda_id' => $pricesc->moneda_id,
                    'curso_id' => $courseId,
                    'user_id' => $pricesc->user_id,
                    'price_id' => $request->precio_id
                ]);
            }
        }

        return redirect()->route('author.cursos.index')->with('info','El curso se creó con éxito');
    }

    public function edit(string $id)
    {

        $coursess = Curso::where('slug', $id)->get();
        $course = $coursess->first();

        $this->authorize('dicatated', $course);

        $categorias = Categoria::pluck('nombre', 'id');
        $niveles = Nivel::pluck('nombre', 'id');
        $precios = Price::pluck('nombre', 'id');
        $garantias = Garantia::pluck('nombre', 'id');
        $tipo_formatos = Tipo_formato::pluck('nombre', 'id');
        $monedas = Moneda::select('id', 'nombre', 'abreviatura')->where('estado', 1)->get();
        
        $empresas = Empresa::pluck('nombre', 'id');
        $allDepartamentos = Departamento::select('id', 'nombre', 'empresa_id')->get();
        $departamentos = [];
        if($course->empresa_id){
            $departamentos = Departamento::where('empresa_id', $course->empresa_id)->pluck('nombre', 'id');
        }

        return view('author.cursos.edit', compact('course', 'categorias', 'niveles', 'precios', 'garantias', 'tipo_formatos', 'monedas', 'empresas', 'departamentos', 'allDepartamentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $coursess = Curso::where('slug', $id)->get();
        $course = $coursess->first();

        $this->authorize('dicatated', $course);

        $categorias = Categoria::pluck('nombre', 'id');
        $niveles = Nivel::pluck('nombre', 'id');
        $precios = Price::pluck('nombre', 'id');
        $garantias = Garantia::pluck('nombre', 'id');
        $tipo_formatos = Tipo_formato::pluck('nombre', 'id');
        $monedas = Moneda::select('id', 'nombre', 'abreviatura')->where('estado', 1)->get();
        
        $empresas = Empresa::pluck('nombre', 'id');
        $departamentos = [];
        // Mantener departamentos para la vista si falla la validación o updated, aunque redirect suele ser normal.
        // Aquí retornamos view directamente al final, así que necesitamos los datos.
        

        $request->validate([
            'nombre' => 'required',
            'slug' => 'required|unique:cursos,slug,' . $course->id,
            'subtitulo' => 'required',
            'descripcion' => 'required',
            'categoria_id' => 'required',
            'nivel_id' => 'required',
            'precio_id' => 'required',
            'file' => 'image',
            'empresa_id' => 'nullable|exists:empresas,id',
            'departamento_id' => 'nullable|exists:departamentos,id',
        ]);
        
        $data = $request->all();
        $data['is_public'] = $request->has('is_public');
        
        if ($data['is_public']) {
            $data['empresa_id'] = null;
            $data['departamento_id'] = null;
        }

        $course->update($data);

        if ($request->file('file')) {
            $url = Storage::put('cursos', $request->file('file'));

            if ($course->image) {
                Storage::delete($course->image->url);
                $course->image->update([
                    'url' => $url
                ]);
            } else {
                $course->image()->create([
                    'url' => $url
                ]);
            }
        }
        
        // Recargar departamentos para la vista
        if($course->empresa_id){
             $departamentos = Departamento::where('empresa_id', $course->empresa_id)->pluck('nombre', 'id');
        }

        $allDepartamentos = Departamento::select('id', 'nombre', 'empresa_id')->get();

        return view('author.cursos.edit', compact('course', 'categorias', 'niveles', 'precios', 'garantias', 'tipo_formatos', 'monedas', 'empresas', 'departamentos', 'allDepartamentos'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $course)
    {
        //
    }

    public function objetivos(Curso $course)
    {
        $this->authorize('dicatated', $course);
        return view('author.cursos.objetivos', compact('course'));
    }

    public function status(Curso $course)
    {
        $this->authorize('dicatated', $course);
        $course->status = 2;
        $course->save();

        $course->observation()->delete();
        return redirect()->route('author.cursos.edit', $course);
    }

    public function observacion(Curso $course)
    {
        $this->authorize('dicatated', $course);
        return view('author.cursos.observacion', compact('course'));
    }

    public function image(Curso $course)
    {
        $this->authorize('dicatated', $course);
        // $data=Storage::get($course->image->url);
        // return view('author.cursos.image',compact('course'));
        // // $data=Storage::get($course->image->url);
        // // $base64='data:image/image;base64,' . base64_encode($data);
        // // return view('author.cursos.image',['src'=>$base64]);
        // $data='data:image/image;base64,' . base64_encode(Storage::get($course->image->url));
        //
        return view('author.cursos.image', compact('course'));
    }

    public function finalExam(Curso $course)
    {
        $this->authorize('dicatated', $course);
        return view('author.cursos.final-exam', compact('course'));
    }
}
