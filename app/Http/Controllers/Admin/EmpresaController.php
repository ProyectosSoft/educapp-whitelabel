<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresas = Empresa::all();
        return view('admin.empresas.index', compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.empresas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'nit' => 'nullable|string|max:255',
                'slug' => 'required|string|max:255|unique:empresas',
                'ceo_nombre' => 'required|string|max:255',
                'ceo_firma' => 'nullable|image|max:2048', // PNG/JPG max 2MB
                'ceo_firma_data' => 'nullable|string', // Base64 signature
                'estado' => 'boolean'
            ]);

            if (!$request->hasFile('ceo_firma') && !$request->filled('ceo_firma_data')) {
                return back()->withErrors(['ceo_firma' => 'Debe subir una firma o dibujar una.'])->withInput();
            }

            $path = null;
            $disk = 'do'; 
            
            // Check if disk exists
            if (!config("filesystems.disks.{$disk}")) {
                throw new \Exception("El disco de almacenamiento '{$disk}' no está configurado.");
            }
            
            // Handle File Upload
            if ($request->hasFile('ceo_firma')) {
                $file = $request->file('ceo_firma');
                $filename = 'firma_' . time() . '.' . $file->getClientOriginalExtension();
                // Folder: Empresa-Firmas-ceo
                $path = $file->storeAs('Empresa-Firmas-ceo', $filename, $disk);
            } 
            // Handle Base64 Signature
            elseif ($request->filled('ceo_firma_data')) {
                $data = $request->ceo_firma_data;
                // Remove data:image/png;base64, header if present
                if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
                    $data = substr($data, strpos($data, ',') + 1);
                    $type = strtolower($type[1]); // jpg, png, gif

                    if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                        throw new \Exception('Tipo de imagen inválido');
                    }
                    $data = base64_decode($data);
                    if ($data === false) {
                        throw new \Exception('Decodificación de firma base64 falló');
                    }
                } else {
                    throw new \Exception('Formato de datos de firma inválido');
                }

                $filename = 'firma_digital_' . time() . '.png';
                $path = 'Empresa-Firmas-ceo/' . $filename;
                \Illuminate\Support\Facades\Storage::disk($disk)->put($path, $data, 'public');
            }

            $empresa = Empresa::create([
                'nombre' => $request->nombre,
                'nit' => $request->nit,
                'slug' => $request->slug,
                'ceo_nombre' => $request->ceo_nombre,
                'ceo_firma' => $path,
                'estado' => $request->has('estado') ? 1 : 0,
            ]);

            return redirect()->route('admin.empresas.index')->with('success', 'Empresa creada correctamente.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput()->with('error', 'Faltan datos obligatorios.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error creando empresa: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error inesperado: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Empresa $empresa)
    {
        return view('admin.empresas.show', compact('empresa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empresa $empresa)
    {
        $this->authorize('update', $empresa);
        return view('admin.empresas.edit', compact('empresa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empresa $empresa)
    {
        $this->authorize('update', $empresa);
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'nit' => 'nullable|string|max:255',
                'slug' => 'required|string|max:255|unique:empresas,slug,' . $empresa->id,
                'ceo_nombre' => 'required|string|max:255',
                'ceo_firma' => 'nullable|image|max:2048',
                'ceo_firma_data' => 'nullable|string',
                'estado' => 'boolean'
            ]);

            $data = $request->except(['ceo_firma', 'ceo_firma_data']);
            $data['estado'] = $request->has('estado') ? 1 : 0;
            $disk = 'do';

             // Check if disk exists
            if (!config("filesystems.disks.{$disk}")) {
                throw new \Exception("El disco de almacenamiento '{$disk}' no está configurado.");
            }

            $newPath = null;
            if ($request->hasFile('ceo_firma')) {
                 $file = $request->file('ceo_firma');
                 $filename = 'firma_' . time() . '.' . $file->getClientOriginalExtension();
                 $newPath = $file->storeAs('Empresa-Firmas-ceo', $filename, $disk);
            } elseif ($request->filled('ceo_firma_data')) {
                 $rawData = $request->ceo_firma_data;
                 // Remove data:image/png;base64, header if present
                 if (preg_match('/^data:image\/(\w+);base64,/', $rawData, $type)) {
                    $rawData = substr($rawData, strpos($rawData, ',') + 1);
                    $type = strtolower($type[1]); // jpg, png, gif

                    if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                        throw new \Exception('Tipo de imagen inválido');
                    }
                    $image_base64 = base64_decode($rawData);
                    if ($image_base64 === false) {
                        throw new \Exception('Decodificación de firma base64 falló');
                    }
                    $filename = 'firma_digital_' . time() . '.png';
                    $newPath = 'Empresa-Firmas-ceo/' . $filename;
                    \Illuminate\Support\Facades\Storage::disk($disk)->put($newPath, $image_base64, 'public');

                 } else {
                     // Could be already base64 without header? Or invalid.
                     // Let's assume invalid if no header for now to be safe, or try generic decode
                     throw new \Exception('Formato de datos de firma inválido');
                 }
            }

            if ($newPath) {
                 // Delete old file if exists
                 if ($empresa->ceo_firma) {
                      \Illuminate\Support\Facades\Storage::disk($disk)->delete($empresa->ceo_firma);
                 }
                 $data['ceo_firma'] = $newPath;
            }

            $empresa->update($data);

            if (auth()->user()->hasRole('Administrador de Empresa')) {
                return redirect()->route('admin.empresas.edit', $empresa->id)->with('success', 'Empresa actualizada correctamente.');
            }

            return redirect()->route('admin.empresas.index')->with('success', 'Empresa actualizada correctamente.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput()->with('error', 'Faltan datos obligatorios.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error actualizando empresa: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error inesperado: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empresa $empresa)
    {
        if ($empresa->ceo_firma) {
            \Illuminate\Support\Facades\Storage::disk('do')->delete($empresa->ceo_firma);
        }
        $empresa->delete();
        return redirect()->route('admin.empresas.index')->with('success', 'Empresa eliminada correctamente.');
    }

    // Company Admin Methods
    public function cursosIndex()
    {
        $user = auth()->user();
        $empresa = Empresa::findOrFail($user->empresa_id);
        $this->authorize('update', $empresa);
        
        $cursos = \App\Models\Curso::where('empresa_id', $empresa->id)
            ->with(['teacher', 'Categoria'])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.empresas.cursos-index', compact('empresa', 'cursos'));
    }

    public function instructoresIndex()
    {
        $user = auth()->user();
        $empresa = Empresa::findOrFail($user->empresa_id);
        $this->authorize('update', $empresa);
        
        $instructores = \App\Models\User::where('empresa_id', $empresa->id)
            ->role('Instructor')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.empresas.instructores-index', compact('empresa', 'instructores'));
    }

    public function alumnosIndex()
    {
        $user = auth()->user();
        $empresa = Empresa::findOrFail($user->empresa_id);
        $this->authorize('update', $empresa);
        
        $alumnos = \App\Models\User::where('empresa_id', $empresa->id)
            ->role('Alumno')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.empresas.alumnos-index', compact('empresa', 'alumnos'));
    }

    public function certificacionesIndex()
    {
        $user = auth()->user();
        $empresa = Empresa::findOrFail($user->empresa_id);
        $this->authorize('update', $empresa);
        return view('admin.empresas.certificaciones-index', compact('empresa'));
    }

    // Categorias Management
    public function categoriasIndex()
    {
        $user = auth()->user();
        $empresa = Empresa::findOrFail($user->empresa_id);
        $this->authorize('update', $empresa);
        
        $categorias = \App\Models\Categoria::where('empresa_id', $empresa->id)->orderBy('id', 'desc')->get();
        return view('admin.empresas.categorias-index', compact('empresa', 'categorias'));
    }

    public function categoriasStore(Request $request) {
        $user = auth()->user();
        $empresa = Empresa::findOrFail($user->empresa_id);
        $this->authorize('update', $empresa);

        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        \App\Models\Categoria::create([
            'nombre' => $request->nombre,
            'slug' => \Illuminate\Support\Str::slug($request->nombre),
            'empresa_id' => $empresa->id,
            'es_publica' => $request->has('es_publica'),
            'estado' => 1
        ]);

        return redirect()->back()->with('success', 'Categoría creada correctamente.');
    }

    public function categoriasUpdate(Request $request, \App\Models\Categoria $categoria) {
        $user = auth()->user();
        // Ensure category belongs to this company
        if($categoria->empresa_id !== $user->empresa_id) {
             abort(403);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $categoria->update([
            'nombre' => $request->nombre,
            'slug' => \Illuminate\Support\Str::slug($request->nombre),
            'es_publica' => $request->has('es_publica')
        ]);

        return redirect()->back()->with('success', 'Categoría actualizada correctamente.');
    }

    public function categoriasDestroy(\App\Models\Categoria $categoria) {
        $user = auth()->user();
         // Ensure category belongs to this company
         if($categoria->empresa_id !== $user->empresa_id) {
            abort(403);
       }
       
       $categoria->delete();
       return redirect()->back()->with('success', 'Categoría eliminada correctamente.');
    }

    // Subcategorias Management
    public function subcategoriasIndex()
    {
        $user = auth()->user();
        $empresa = Empresa::findOrFail($user->empresa_id);
        $this->authorize('update', $empresa);
        
        $subcategorias = \App\Models\Subcategoria::where('empresa_id', $empresa->id)
            ->with('Categoria')
            ->orderBy('id', 'desc')
            ->get();
            
        // For creating subcategories, we need available categories
        // User requested that "Academia Effi" (global or other) should NOT appear.
        // So we strictly filter by the current company's ID.
        $categorias = \App\Models\Categoria::where('empresa_id', $empresa->id)->orderBy('nombre')->get();

        return view('admin.empresas.subcategorias-index', compact('empresa', 'subcategorias', 'categorias'));
    }

    public function subcategoriasStore(Request $request) {
        $user = auth()->user();
        $empresa = Empresa::findOrFail($user->empresa_id);
        $this->authorize('update', $empresa);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        \App\Models\Subcategoria::create([
            'nombre' => $request->nombre,
            'slug' => \Illuminate\Support\Str::slug($request->nombre),
            'categoria_id' => $request->categoria_id,
            'empresa_id' => $empresa->id,
            'es_publica' => $request->has('es_publica'),
            'estado' => 1
        ]);

        return redirect()->back()->with('success', 'Subcategoría creada correctamente.');
    }

    public function subcategoriasUpdate(Request $request, \App\Models\Subcategoria $subcategoria) {
        $user = auth()->user();
        // Ensure subcategory belongs to this company
        if($subcategoria->empresa_id !== $user->empresa_id) {
             abort(403);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $subcategoria->update([
            'nombre' => $request->nombre,
            'slug' => \Illuminate\Support\Str::slug($request->nombre),
            'categoria_id' => $request->categoria_id,
            'es_publica' => $request->has('es_publica')
        ]);

        return redirect()->back()->with('success', 'Subcategoría actualizada correctamente.');
    }

    public function subcategoriasDestroy(\App\Models\Subcategoria $subcategoria) {
        $user = auth()->user();
         // Ensure subcategory belongs to this company
         if($subcategoria->empresa_id !== $user->empresa_id) {
            abort(403);
       }
       
       $subcategoria->delete();
       return redirect()->back()->with('success', 'Subcategoría eliminada correctamente.');
    }
}
