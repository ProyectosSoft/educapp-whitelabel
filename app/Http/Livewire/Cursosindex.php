<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Curso;
use App\Models\Categoria;
use App\Models\Nivel;

use Livewire\WithPagination;
class Cursosindex extends Component
{
    use WithPagination;

    public $categoria_id;
    public $nivel_id;

    protected $queryString = [
        'categoria_id' => ['as' => 'category', 'except' => ''],
        'nivel_id' => ['as' => 'level', 'except' => ''],
    ];

    public function mount()
    {
        $this->categoria_id = request()->query('category', $this->categoria_id);
        $this->nivel_id = request()->query('level', $this->nivel_id);
    }

    public function updatingCategoriaId()
    {
        $this->resetPage();
    }

    public function updatingNivelId()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->user();
        $userEmpresaId = $user && $user->departamento ? $user->departamento->empresa_id : null;
        $userDeptoId = $user?->departamento_id;

        if ($user && $user->empresa_id) {
            $categorias = Categoria::paraEmpresa($user->empresa_id)->get();
        } else {
            $categorias = Categoria::publicas()->get();
        }

        $niveles = Nivel::all();

        $coursesQuery = Curso::where('status', Curso::PUBLICADO)
            ->Categoria($this->categoria_id)
            ->Nivel($this->nivel_id);

        if ($user) {
            $coursesQuery->where(function ($q) use ($userEmpresaId, $userDeptoId) {
                $q->where('is_public', true);

                if ($userEmpresaId) {
                    $q->orWhere(function ($sub) use ($userEmpresaId, $userDeptoId) {
                        $sub->where('is_public', false)
                            ->where('empresa_id', $userEmpresaId)
                            ->where(function ($deep) use ($userDeptoId) {
                                $deep->whereNull('departamento_id')
                                    ->orWhere('departamento_id', $userDeptoId);
                            });
                    });
                }
            });
        } else {
            $coursesQuery->where('is_public', true);
        }

        $courses = $coursesQuery
            ->latest('id')
            ->paginate(8);

        return view('livewire.cursosindex', compact('courses', 'categorias', 'niveles'));
    }

    public function resetFilters(){
        $this->reset(['categoria_id','nivel_id']);
        $this->resetPage();
    }
}
