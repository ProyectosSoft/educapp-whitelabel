<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departamentos = Departamento::with('empresa')->get();
        return view('admin.departamentos.index', compact('departamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresas = \App\Models\Empresa::all();
        return view('admin.departamentos.create', compact('empresas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'nombre' => 'required|string|max:255',
            'jefe_nombre' => 'required|string|max:255',
            'jefe_firma' => 'nullable|image|max:2048', // PNG/JPG max 2MB
            'jefe_firma_data' => 'nullable|string',
        ]);

        if (!$request->hasFile('jefe_firma') && !$request->filled('jefe_firma_data')) {
            return back()->withErrors(['jefe_firma' => 'Debe subir una firma o dibujar una.']);
        }

        $empresa = \App\Models\Empresa::findOrFail($request->empresa_id);
        // Authorization: Ensure user can manage this specific company
        $this->authorize('update', $empresa); 

        $path = null;
        $disk = 'do';
        $deptoName = \Illuminate\Support\Str::slug($request->nombre);
        $folderName = "Empresa-Firmas-lider-{$deptoName}";

        if ($request->hasFile('jefe_firma')) {
            $file = $request->file('jefe_firma');
            $filename = 'firma_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs($folderName, $filename, $disk);
        } elseif ($request->filled('jefe_firma_data')) {
             $image_parts = explode(";base64,", $request->jefe_firma_data);
             if (count($image_parts) == 2) {
                 $image_type_aux = explode("image/", $image_parts[0]);
                 $image_type = $image_type_aux[1]; 
                 $image_base64 = base64_decode($image_parts[1]);
                 $filename = 'firma_digital_' . time() . '.' . $image_type;
                 $path = $folderName . '/' . $filename;
                 \Illuminate\Support\Facades\Storage::disk($disk)->put($path, $image_base64, 'public');
             }
        }

        Departamento::create([
            'empresa_id' => $request->empresa_id,
            'nombre' => $request->nombre,
            'jefe_nombre' => $request->jefe_nombre,
            'jefe_firma' => $path,
        ]);

        return redirect()->route('admin.empresas.edit', $request->empresa_id)->with('success', 'Departamento creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Departamento $departamento)
    {
        return view('admin.departamentos.show', compact('departamento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departamento $departamento)
    {
        $empresas = \App\Models\Empresa::all();
        return view('admin.departamentos.edit', compact('departamento', 'empresas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departamento $departamento)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'nombre' => 'required|string|max:255',
            'jefe_nombre' => 'required|string|max:255',
            'jefe_firma' => 'nullable|image|max:2048',
            'jefe_firma_data' => 'nullable|string',
        ]);

        $data = $request->except(['jefe_firma', 'jefe_firma_data']);
        $disk = 'do';

        $deptoName = \Illuminate\Support\Str::slug($request->nombre);
        $folderName = "Empresa-Firmas-lider-{$deptoName}";
        
        $newPath = null;
        if ($request->hasFile('jefe_firma')) {
             $file = $request->file('jefe_firma');
             $filename = 'firma_' . time() . '.' . $file->getClientOriginalExtension();
             $newPath = $file->storeAs($folderName, $filename, $disk);
        } elseif ($request->filled('jefe_firma_data')) {
             $image_parts = explode(";base64,", $request->jefe_firma_data);
             if (count($image_parts) == 2) {
                 $image_type_aux = explode("image/", $image_parts[0]);
                 $image_type = $image_type_aux[1]; 
                 $image_base64 = base64_decode($image_parts[1]);
                 $filename = 'firma_digital_' . time() . '.' . $image_type;
                 $newPath = $folderName . '/' . $filename;
                 \Illuminate\Support\Facades\Storage::disk($disk)->put($newPath, $image_base64, 'public');
             }
        }

        if ($newPath) {
             if ($departamento->jefe_firma) {
                  \Illuminate\Support\Facades\Storage::disk($disk)->delete($departamento->jefe_firma);
             }
             $data['jefe_firma'] = $newPath;
        }

        $departamento->update($data);

        return redirect()->route('admin.empresas.edit', $request->empresa_id)->with('success', 'Departamento actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departamento $departamento)
    {
        $empresaId = $departamento->empresa_id;
        if ($departamento->jefe_firma) {
            \Illuminate\Support\Facades\Storage::disk('do')->delete($departamento->jefe_firma);
        }
        $departamento->delete();
        return redirect()->route('admin.empresas.edit', $empresaId)->with('success', 'Departamento eliminado correctamente.');
    }
}
