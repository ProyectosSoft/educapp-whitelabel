<?php

namespace App\Http\Livewire\Author;

use Livewire\Component;
use App\Models\Referralcode;
use App\Models\Cupon;
use App\Models\Curso;
use Livewire\WithPagination;
use Carbon\Carbon;

class CursosLinkReferral extends Component
{
    use WithPagination;
    public $course, $search, $nombre, $codigo, $fecha_inicio, $fecha_final, $valor, $cantidad, $estado, $open;
    public $openForm2 = false;
    public $referralId = 0;

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

        $referralcodes = Referralcode::where('curso_id', $course_id)->get();

        // Verifica si $this->search es una cadena y aplica la búsqueda si es el caso
        if ($this->search) {
            $referralcodes->where('nombre', 'LIKE', '%' . $this->search . '%');
        }
         return view('livewire.author.cursos-link-referral',compact('referralcodes'))->layout('layouts.author', ['course' => $this->course]);;
    }

    public function abrirFormulario()
    {
        $this->openForm2 = true;
        // Restablecer cuponId cuando se abra el formulario para evitar conflictos
        $this->referralId = null;
    }

    public function editarCupon($referralId)
    {
        $this->referralId = $referralId;
        $this->openForm2 = true;
    }

    public function edit($referralId)
    {
        $Referralcode = Referralcode::find($referralId);
        if ( $Referralcode) {
            $this->referralId =  $Referralcode->id;
            $this->nombre =  $Referralcode->nombre;
            $this->codigo =  $Referralcode->codigo;
            $this->fecha_inicio = $this->fecha_inicio = Carbon::createFromFormat('Y-m-d H:i:s',  $Referralcode->fecha_inicio)->format('Y-m-d');
            $this->fecha_final = $this->fecha_final = Carbon::createFromFormat('Y-m-d H:i:s',  $Referralcode->fecha_fin)->format('Y-m-d');
            $this->valor =  $Referralcode->valor;
            $this->cantidad =  $Referralcode->cantidad;
            $this->estado =  $Referralcode->estado;
            $this->openForm2 = true; // Abre el formulario de edición
        }
    }

    public function saveOrUpdate()
    {
         if ($this->referralId>0) {
            $referral = Referralcode::find($this->referralId);
            if ($referral) {
                $referral->update([
                    'nombre' => $this->nombre,
                    'codigo' => $this->codigo,
                    'fecha_inicio' => $this->fecha_inicio,
                    'fecha_final' => $this->fecha_final,
                    'valor' => $this->valor,
                    'cantidad' => $this->cantidad,
                    'estado' => $this->estado,
                ]);
            }
        } else {

                    // Validar los datos
        $this->validate([
            'nombre' => 'required',
            'codigo' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date|after_or_equal:fecha_inicio',
            'valor' => 'required|numeric',
            'cantidad' => 'required|integer|min:0',
            'estado' => 'required|in:0,1',
        ]);
        Referralcode::create([
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

        // Limpiar los campos del formulario y cerrar el formulario
        $this->reset(['nombre', 'codigo', 'fecha_inicio', 'fecha_final', 'valor', 'cantidad', 'estado']);
        $this->openForm2 = false;
    }
}
