<?php

namespace App\Http\Livewire\Alumnos;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\SaldoFavor;
use App\Models\Devolucion;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Financiero extends Component
{
    public $totalSaldo;
    public $totalDevolucion;
    public $totalVenta;
    public $transactions;
    public $startDate;
    public $endDate;
    public $filterName;
    public $filterTransaction;
    public $filterNumber;
    public $sortField;
    public $sortAsc = true;
    public $filtros = [];
    public $filterStatus;
    public $filterNameIns;

    protected $listeners = [
        'confirmAcceptTransaction' => 'acceptTransactionConfirmed'
    ];

    public function mount()
    {
        $this->loadFinancialSummary();
        $this->transactions = Transaction::where('student_id', auth()->user()->id)->get();
    }

    public function render()
    {
        $transactions = Transaction::query();

        // Aplicar filtros seleccionados si es necesario
        if (!empty($this->filtros)) {
            foreach ($this->filtros as $filtro) {
                $this->applyFilter($transactions, $filtro);
            }
        }

        // Ordenar si es necesario
        if ($this->sortField) {
            $transactions->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        }

        // Obtener los resultados y pasar a la vista
        $this->transactions = $transactions->get();

        return view('livewire.alumnos.financiero', [
            'transactions' => $this->transactions,
        ]);
    }

    public function toggleMostrarTabla($tipo)
    {
        switch ($tipo) {
            case 'compras':
                $this->transactions = Transaction::where('transaction', 'Venta')->get();
                break;
            case 'devoluciones':
                $this->transactions = Transaction::where('transaction', 'Devolucion')->get();
                break;
            case 'saldo_favor':
                $this->transactions = Transaction::where('transaction', 'Saldo a Favor')->get();
                break;
            default:
                $this->transactions = Transaction::all();
                break;
        }
        $this->filtros[] = $tipo;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }
        $this->sortField = $field;

        $this->transactions = Transaction::orderBy($field, $this->sortAsc ? 'asc' : 'desc')->get();
    }

    public function applyFilters()
    {
        $query = Transaction::query();

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('date', [$this->startDate, $this->endDate]);
        }

        if ($this->filterName) {
            $query->where('name', 'like', '%' . $this->filterName . '%');
        }

        if ($this->filterTransaction) {
            $query->where('transaction', 'like', '%' . $this->filterTransaction . '%');
        }

        if ($this->filterStatus) {
            $query->where('status', '=', $this->filterStatus);
        }

        $this->transactions = $query->get();
    }

    public function resetFiltersAndTransactions()
    {
        $this->startDate = null;
        $this->endDate = null;
        $this->filterName = null;
        $this->filterNameIns = null;
        $this->filterTransaction = null;
        $this->filterStatus = null;
        $this->filterNumber = null;
        $this->transactions = Transaction::where('student_id', auth()->user()->id)->get();
    }

    public function quitarFiltro($filtro)
    {
        $this->filtros = array_diff($this->filtros, [$filtro]);
    }

    public function toggleFiltro($filtro)
    {
        if (in_array($filtro, $this->filtros)) {
            $this->filtros = array_diff($this->filtros, [$filtro]);
        } else {
            $this->filtros[] = $filtro;
        }

        $this->applyFilters();
    }

    protected function loadFinancialSummary()
    {
        $totalVentas = Order::where('user_id', auth()->user()->id)
                           ->where('status', 6)
                           ->get()->sum(function ($order) {
                               return $order->items->sum('total');
                           });

        $totalDevolucions = Devolucion::where('user_id', auth()->user()->id)
                                     ->where('status', 1)
                                     ->get()->sum(function ($devolucion) {
                                         return $devolucion->items->sum('total');
                                     });

        $this->totalSaldo = number_format(SaldoFavor::where('student_id', auth()->user()->id)
                                                   ->where('status', 1)
                                                   ->sum('saldo_restante'), 2, '.', ',');

        $this->totalDevolucion = number_format($totalDevolucions, 2, '.', ',');
        $this->totalVenta = number_format($totalVentas, 2, '.', ',');
    }

    protected function applyFilter($query, $filtro)
    {
        switch ($filtro) {
            case 'Saldo a Favor':
                $query->orWhere('transaction', 'Saldo a Favor');
                break;
            case 'Venta':
                $query->orWhere('transaction', 'Venta');
                break;
            case 'Devolucion':
                $query->orWhere('transaction', 'Devolucion');
                break;
            // Agrega más filtros según sea necesario
        }
    }
}
