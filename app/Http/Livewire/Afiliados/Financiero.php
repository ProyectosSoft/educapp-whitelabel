<?php

namespace App\Http\Livewire\Afiliados;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\SaldoFavor;
use App\Models\Devolucion;
use App\Models\Order;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;
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

    protected $listeners = [
        'confirmAcceptTransaction' => 'acceptTransactionConfirmed'
    ];
    public function mount()
    {

        $this->filtros = ['Devoluciones', 'Saldo_favor', 'Compras'];
        $totalVentas = 0;
        $totalDevolucions = 0;

        $userOrders = Order::where('user_id', auth()->user()->id)->get();
        $userDevolucions = Devolucion::where('user_id', auth()->user()->id)->get();
        $this->totalSaldo = number_format(SaldoFavor::sum('saldo_restante'), 2, '.', ',');
        // Iterar sobre cada orden del usuario y sumar el total de los ítems de la orden
        foreach ($userOrders as $order) {
            // Sumar el total de los ítems de la orden actual
            $totalVentas += $order->items->sum('total');
        }

        // Iterar sobre cada orden del usuario y sumar el total de los ítems de la orden
        foreach ($userDevolucions as $devolucion) {
            // Sumar el total de los ítems de la orden actual
            $totalDevolucions += $devolucion->items->sum('total');
        }
        $this->totalDevolucion = number_format($totalDevolucions, 2, '.', ',');
        $this->totalVenta = number_format($totalVentas, 2, '.', ',');
        // $this->transactions = Transaction::all(); // Obtén las transacciones según sea necesario
        $this->transactions = Transaction::where('student_id', auth()->user()->id)->get();
    }

    public function toggleMostrarTabla($tipo)
    {
        // Filtrar las transacciones por el tipo específico
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
                // Si no se proporciona un tipo válido, mostrar todas las transacciones
                $this->transactions = Transaction::all();
                break;
        }
        // Agregar el tipo de transacción como filtro
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


    public function acceptTransaction($transactionId)
    {
        $this->emit('transactionAccepted', $transactionId);
    }

    public function acceptTransactionConfirmed($transactionId)
    {
        // Se Actualiza el estado de la transacción
        $transaction = Transaction::find($transactionId);
        if ($transaction) {
            $transaction->status = 6;
            $transaction->save();

            // Se Actualiza el estado de la devolución
            $devolucion = Devolucion::find($transaction->devolucion_id);
            if ($devolucion) {
                $devolucion->status = 6;
                $devolucion->save();
            }

            // Actualizar el campo 'detail' en las transacciones para reemplazar 'vigente' por 'exitosa'
            $transactions = Transaction::find($transactionId)->get();
            foreach ($transactions as $transaction) {
                $transaction->detail = str_replace("vigente", "exitosa", $transaction->detail);
                $transaction->save();
            }
        }

        // Se crea el saldo a favor
        $saldoFavor = new SaldoFavor();
        $saldoFavor->date = Carbon::now()->toDateString();
        $saldoFavor->name = $transaction->name ;
        $saldoFavor->quantity = 1;
        $saldoFavor->descuento = $transaction->descuento;
        $saldoFavor->subtotal = $transaction->subtotal;
        $saldoFavor->impuestos = $transaction->impuestos;
        $saldoFavor->detail = "Creación: SALDO A FAVOR  (devolución" . $transaction->devolucion_id . " (transacción vigente ) Cliente: ". $transaction->name ;
        $saldoFavor->total = $transaction->total;
        $saldoFavor->saldo_restante = $transaction->total;
        $saldoFavor->observation = "N/A";
        $saldoFavor->status = 1;
        $saldoFavor->devolucion_id = $transaction->devolucion_id;
        $saldoFavor->order_id = $transaction->order_id;
        $saldoFavor->saldo_id = 0;
        $saldoFavor->student_id = $transaction->student_id;
        $saldoFavor->instructor_id = $transaction->instructor_id;
        $saldoFavor->saldo_id = 0;
        $saldoFavor->save();
        // $this->destroy();


        // Se crea el registro en la tabla transacciones con la información del saldo a favor
        $transaccion = new Transaction();
        $transaccion->date = Carbon::now()->toDateString();
        $transaccion->name = auth()->user()->name;
        $transaccion->transaction = "Saldo a Favor";
        $transaccion->number = $saldoFavor->id;
        $transaccion->quantity = 1;
        $transaccion->descuento = $saldoFavor->descuento;
        $transaccion->subtotal = $saldoFavor->subtotal;
        $transaccion->impuestos = $saldoFavor->impuestos;
        $transaccion->detail = "Creación: SALDO A FAVOR  (Devolucion " . $saldoFavor->id . ") (transacción vigente ) cliente: ". $saldoFavor->name;
        $transaccion->total = $saldoFavor->total;
        $transaccion->observation = "N/A";
        $transaccion->status = 1;
        $transaccion->devolucion_id = $transaction->devolucion_id;
        $transaccion->order_id = $transaction->order_id;
        $transaccion->student_id = $transaction->student_id;
        $transaccion->instructor_id = $transaction->instructor_id;
        $transaccion->saldo_id = $saldoFavor->id;
        $transaccion->save();
        // $this->destroy();

        // se redirecciona a la ruta 'afiliados.financiero' con el fin  de actualizar la información de la vista
        redirect()->route('afiliados.financiero');
    }

    public function render()
    {
        $transacciones = Transaction::query();

        // Aplicar filtros seleccionados
        if (!empty($this->filtrosSeleccionados)) {
            $transacciones->whereIn('transaction', $this->filtrosSeleccionados);
        }

        $transacciones = $transacciones->get();

        return view('livewire.afiliados.financiero', [
            'transactions' => $transacciones,
        ]);
    }

    public function quitarFiltro($filtro)
    {
        // Eliminar el filtro del array de filtros
        $this->filtros = array_diff($this->filtros, [$filtro]);

        // Actualizar la tabla según los filtros restantes
        // Aquí deberías implementar la lógica para aplicar los filtros restantes
        // a la consulta de la tabla y actualizar $this->transactions en consecuencia.
    }

    public $filtrosSeleccionados = [];

    public function toggleFiltro($filtro)
    {
        // Verifica si el filtro está seleccionado
        if (in_array($filtro, $this->filtrosSeleccionados)) {
            // Si está seleccionado, desactívalo
            $this->filtrosSeleccionados = array_diff($this->filtrosSeleccionados, [$filtro]);
        } else {
            // Si no está seleccionado, actívalo
            $this->filtrosSeleccionados[] = $filtro;
        }

        // Ejecuta el método para aplicar los filtros y actualizar los datos
        $this->aplicarFiltros();
    }

    public function aplicarFiltros()
    {
        // Inicializa la consulta base
        $query = Transaction::query();

        // Aplica los filtros según los filtros seleccionados
        if (in_array('Saldo a Favor', $this->filtrosSeleccionados)) {
            $query->orWhere('transaction', 'Saldo a Favor');
        }
        if (in_array('Venta', $this->filtrosSeleccionados)) {
            $query->orWhere('transaction', 'Venta');
        }
        if (in_array('Devolucion', $this->filtrosSeleccionados)) {
            $query->orWhere('transaction', 'Devolucion');
        }
        // Agrega más condiciones según tus filtros

        // Ejecuta la consulta y actualiza los datos
        $this->transactions = $query->get();
    }

}
