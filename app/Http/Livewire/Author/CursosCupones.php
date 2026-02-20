<?php

namespace App\Http\Livewire\Author;

use App\Models\Cupon;
use App\Models\Curso;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class CursosCupones extends Component
{
    use WithPagination;
    public $course, $search, $nombre, $codigo, $fecha_inicio, $fecha_final, $valor, $cantidad, $estado, $open;
    public $openForm = false;
    public $cuponId = null;
    public function mount(Curso $course)
    {
        $this->course = $course;
    }

    public function updatingsSearch()
    {
        $this->resetPage();
    }


    public function render()
    {
        $course_id = $this->course->id;

        $cupones = Cupon::where('curso_id', $course_id);

        // Verifica si $this->search es una cadena y aplica la búsqueda si es el caso
        if ($this->search) {
            $cupones->where('nombre', 'LIKE', '%' . $this->search . '%');
        }
        $cupones = $cupones->paginate(4);

        return view('livewire.author.cursos-cupones', compact('cupones'))->layout('layouts.author', ['course' => $this->course]);
    }


    public function abrirFormulario()
    {
        $this->openForm = true;
        // Restablecer cuponId cuando se abra el formulario para evitar conflictos
        $this->cuponId = null;
    }

    public function editarCupon($cuponId)
    {
        $this->cuponId = $cuponId;
        $this->openForm = true;
    }
    public function edit($cuponId)
    {
        $cupon = Cupon::find($cuponId);
        if ($cupon) {
            $this->cuponId = $cupon->id;
            $this->nombre = $cupon->nombre;
            $this->codigo = $cupon->codigo;
            $this->fecha_inicio = $this->fecha_inicio = Carbon::createFromFormat('Y-m-d H:i:s', $cupon->fecha_inicio)->format('Y-m-d');
            $this->fecha_final =$this->fecha_final = Carbon::createFromFormat('Y-m-d H:i:s', $cupon->fecha_fin)->format('Y-m-d');
            $this->valor = $cupon->valor;
            $this->cantidad = $cupon->cantidad;
            $this->estado = $cupon->estado;
            $this->openForm = true; // Abre el formulario de edición
        }
    }
    public function storeOrUpdate()
    {
        if ($this->cuponId) {
            $cupon = Cupon::find($this->cuponId);
            if ($cupon) {
                $cupon->update([
                    'nombre' => $this->nombre,
                    'codigo' => $this->codigo,
                    'fecha_inicio' => $this->fecha_inicio,
                    'fecha_fin' => $this->fecha_final,
                    'valor' => $this->valor,
                    'cantidad' => $this->cantidad,
                    'estado' => $this->estado,
                ]);
            }
        } else {
            $this->validate([
                'nombre' => 'required',
                'codigo' => 'required',
                'fecha_inicio' => 'required',
                'fecha_final' => 'required',
                'valor' => 'required',
                'cantidad' => 'required',
                'estado' => 'required',
            ]);

            Cupon::create([
                'nombre' =>  $this->nombre,
                'codigo' =>  $this->codigo,
                'fecha_inicio' =>  $this->fecha_inicio,
                'fecha_fin' => $this->fecha_final,
                'valor' => $this->valor,
                'cantidad' => $this->cantidad,
                'estado' => $this->estado,
                'curso_id' => $this->course->id,
            ]);
        }
        $this->reset(['nombre', 'codigo', 'fecha_inicio', 'fecha_final', 'valor', 'cantidad', 'estado']);
        $this->openForm = false; // Abre el formulario de edición
    }
}
