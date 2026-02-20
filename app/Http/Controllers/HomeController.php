<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Order;
use App\Models\User;
use App\Models\Categoria;
use App\Models\ExamEvaluation;
use Exception;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{



    public function __invoke()
    {
        // 1. Definir variables de contexto del usuario
        $user = auth()->user();
        $userEmpresaId = null;
        $userDeptoId = null;

        if ($user && $user->departamento) {
            $userDeptoId = $user->departamento_id;
            $userEmpresaId = $user->departamento->empresa_id;
        }

        // 2. Query Builder para Cursos
        $coursesQuery = Curso::where('status', '3'); // Publicado

        if ($user) {
            $coursesQuery->where(function($q) use ($userEmpresaId, $userDeptoId) {
                $q->where('is_public', true);
                if ($userEmpresaId) {
                    $q->orWhere(function($sub) use ($userEmpresaId, $userDeptoId) {
                        $sub->where('is_public', false)
                            ->where('empresa_id', $userEmpresaId)
                            ->where(function($deep) use ($userDeptoId) {
                                $deep->whereNull('departamento_id')
                                     ->orWhere('departamento_id', $userDeptoId);
                            });
                    });
                }
            });
        } else {
            $coursesQuery->where('is_public', true);
        }
        
        $courses = $coursesQuery->latest('id')->take(12)->get();

        // 3. Query Builder para Evaluaciones (Certificaciones)
        $certificationsQuery = ExamEvaluation::where('is_active', true)
            ->with(['instructor', 'categoria']);

        if ($user) { // Cargar intentos solo si hay usuario
             $certificationsQuery->with(['userAttempts' => function($q) use ($user) {
                 $q->where('user_id', $user->id);
             }]);

             $certificationsQuery->where(function($q) use ($userEmpresaId, $userDeptoId) {
                $q->where('is_public', true);
                if ($userEmpresaId) {
                    $q->orWhere(function($sub) use ($userEmpresaId, $userDeptoId) {
                        $sub->where('is_public', false)
                            ->where('empresa_id', $userEmpresaId)
                            ->where(function($deep) use ($userDeptoId) {
                                $deep->whereNull('departamento_id')
                                     ->orWhere('departamento_id', $userDeptoId);
                            });
                    });
                }
            });
        } else {
             $certificationsQuery->where('is_public', true);
        }

        $certifications = $certificationsQuery->latest()->take(4)->get();
        
        // Filter categories based on user's company context
        if ($user && $user->empresa_id) {
            $categorias = Categoria::paraEmpresa($user->empresa_id)->latest()->take(4)->get();
        } else {
            $categorias = Categoria::publicas()->latest()->take(4)->get();
        }

        // 4. Lógica de Redirección y Mensajes (Legacy refactorizada)
        if ($user) {
            // Validar correo (desactivado temporalmente según código original)
            if (false) { 
                session()->flash('flash.banner', "Debe validar su correo electrónico para poder acceder a la plataforma de cursos EducApp");
                return view('welcome', compact('courses', 'categorias', 'certifications'));
            }

            try {
                $perfil = 'NA';
                if ($user->roles->count() > 0) {
                    $perfil = $user->roles->pluck('name')->implode(' ');
                    
                    // Verificar pagos pendientes
                    $pendiente = Order::where('status', 1)->where('user_id', $user->id)->count();
                    if ($pendiente > 0) {
                        session()->flash('flash.banner', "Tienes $pendiente matricula pendiente de pago. <a class='font-bold' href='" . route('orders.index') . "?status=1'>Ir a pagar</a>");
                    }
                } else {
                    session()->flash('flash.banner', "Aún nos ha seleccionado tu perfil. <a class='font-bold' href='" . route('perfil.index') . "?status=1'>Ir a perfil</a>");
                }
                
                return view('welcome', compact('courses', 'perfil', 'categorias', 'certifications'));

            } catch (Exception $e) {
                session()->flash('flash.banner', "Aún nos ha seleccionado tu perfil.");
                return view('welcome', compact('courses', 'categorias', 'certifications', 'perfil')); // Perfil puede no estar definido en catch, cuidado.
            }
        }

        return view('welcome', compact('courses', 'categorias', 'certifications'));
    }
}
