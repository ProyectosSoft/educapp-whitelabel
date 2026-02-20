<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all();
        return view ('admin.categorias.index',compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
           'nombre' => 'required|unique:categorias',
           'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=640,min_height=480,max_width=640,max_height=480',
           'descripcion' => 'nullable|string|max:255',
        ]);
        $url=null;
        if($request->file('imagen')){
            $url=Storage::put('public/categories',$request->file('imagen'));
        }
        $categoria= Categoria::create([
            'nombre' => $request->nombre,
            'slug' => $request->nombre,
            'estado' =>1,
            'image' => $url,
            'description' => $request->descripcion,

        ]);

        return redirect()->route('admin.categorias.edit',$categoria)->with('info','La categoria se creó con éxito');

    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        return view ('admin.categorias.show',compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        return view ('admin.categorias.edit',compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|unique:categorias,nombre,' . $categoria->id,
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=640,min_height=480,max_width=640,max_height=480',
            'descripcion' => 'nullable|string|max:255',
         ]);

         $data = [
            'nombre' => $request->nombre,
            'slug' => $request->nombre,
            'estado' => 1,
            'description' => $request->descripcion,
         ];

         if($request->file('imagen')){
             if ($categoria->image) {
                Storage::delete($categoria->image);
             }
             $data['image'] = Storage::put('public/categories', $request->file('imagen'));
         }

         $categoria->update($data);
        return redirect()->route('admin.categorias.edit',$categoria)->with('info','La categoria se actualizó con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        if ($categoria->Subcategorias()->count() > 0) {
            return redirect()->route('admin.categorias.index')->with('error', 'No se puede eliminar la categoría porque tiene subcategorías asociadas.');
        }

        if ($categoria->Curso()->count() > 0) {
            return redirect()->route('admin.categorias.index')->with('error', 'No se puede eliminar la categoría porque tiene cursos asociados.');
        }

        if ($categoria->image) {
            Storage::delete($categoria->image);
        }
        $categoria->delete();
        return redirect()->route('admin.categorias.index')->with('info','La categoría se eliminó con éxito');
    }
}
