<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\SaldoFavor;
use App\Models\Devolucion;
use App\Models\Order;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;
use App\Models\comprobante_pago;
use App\Models\comprobante_pago_detalle;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class Financiero extends Component
{
    public $totalSaldo;
    public $totalDevolucion;
    public $totalVenta;
    public $transactions;
    public $startDate;
    public $endDate;
    public $filterName;
    public $filterNameIns;
    public $filterTransaction;
    public $filterStatus;
    public $filterNumber;
    public $sortField;
    public $sortAsc = true;
    public $filtros = [];
    public $selectedTransactions = [];
    public $selectAll = false;

    protected $listeners = [
        'confirmAcceptTransaction' => 'acceptTransactionConfirmed'
    ];
    public function mount()
    {
        $totalVentas = 0;
        $totalDevolucions = 0;
        $totalVentas = Order::sum('total');
        $totalDevolucions = Devolucion::where('status', 1)->sum('total');
        $this->totalSaldo = number_format(SaldoFavor::where('status', 1)->sum('saldo_restante'), 2, '.', ',');
        $this->totalDevolucion = number_format($totalDevolucions, 2, '.', ',');
        $this->totalVenta = number_format($totalVentas, 2, '.', ',');
        $this->transactions = Transaction::all();
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
            case 'Rango_Fecha':
                $this->transactions = Transaction::where('date', '>=', Carbon::parse($this->startDate))->get();
                break;
            case 'Nombre':
                $this->transactions = Transaction::where('name', 'like', '%' . $this->filterName . '%')->get();
                break;
            case 'instructor_name':
                $this->transactions = Transaction::where('instructor_name', 'like', '%' . $this->filterNameIns . '%')->get();
                break;
            case 'transaction':
                $this->transactions = Transaction::where('transaction', 'like', '%' . $this->filterTransaction . '%')->get();
                break;
            case 'status':
                $this->transactions = Transaction::where('status', '=', $this->filterStatus)->get();
                break;
            default:
                // Si no se proporciona un tipo válido, mostrar todas las transacciones
                $this->transactions = Transaction::all();
                break;
        }
        // Agregar el tipo de transacción como filtro
        $this->filtros[] = $tipo;
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
        if ($this->filterTransaction){
            $query->where('transaction', 'like', '%' . $this->filterTransaction . '%')->get();
        }
        if ($this->filterStatus){
            $query->where('status', '=', $this->filterStatus)->get();
        }
        // Agrega otros filtros según sea necesario...
        $this->transactions = $query->get();
    }

    public function resetFiltersAndTransactions()
    {
        // Reinicia los valores de los filtros
        $this->startDate = null;
        $this->endDate = null;
        $this->filterName = null;
        $this->filterNameIns = null;
        $this->filterTransaction = null;
        $this->filterStatus = null;
        $this->filterNumber = null;
        // Reinicia la lista de transacciones
        $this->transactions = Transaction::all();
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
        $transaction = Transaction::where('id', $transactionId)->first();
        if ($transaction) {
            $transaction->status = 6;
            $transaction->save();

            // Se Actualiza el estado de la devolución
            $devolucion = Devolucion::find($transaction->devolucion_id);
            if ($devolucion) {
                $devolucion->status = 6;
                $devolucion->observation = str_replace("vigente", "exitosa", $devolucion->observation);
                $devolucion->save();
            }

            // Actualizar el campo 'detail' en las transacciones para reemplazar 'vigente' por 'exitosa'
            $transactions = Transaction::where('id', $transactionId)->get();
            foreach ($transactions as $transaction) {
                $transaction->detail = str_replace("vigente", "exitosa", $transaction->detail);
                $transaction->save();
            }
        }

        // Se crea el saldo a favor
        $saldoFavor = new SaldoFavor();
        $saldoFavor->date = Carbon::now()->toDateString();
        $saldoFavor->name = $transaction->name;
        $saldoFavor->quantity = 1;
        $saldoFavor->descuento = $transaction->descuento;
        $saldoFavor->subtotal = $transaction->subtotal;
        $saldoFavor->impuestos = $transaction->impuestos;
        $saldoFavor->detail = "Creación: SALDO A FAVOR  (devolución" . $transaction->devolucion_id . " (transacción vigente ) Cliente: " . $transaction->name;
        $saldoFavor->total = $transaction->total;
        $saldoFavor->saldo_restante = $transaction->total;
        $saldoFavor->observation = "N/A";
        $saldoFavor->status = 1;
        $saldoFavor->devolucion_id = $transaction->devolucion_id;
        $saldoFavor->order_id = $transaction->order_id;
        $saldoFavor->saldo_id = 0;
        $saldoFavor->student_id = $transaction->student_id;
        $saldoFavor->instructor_id = $transaction->instructor_id;
        $saldoFavor->instructor_name = $transaction->instructor_name;
        $saldoFavor->curso_id = $transaction->curso_id;
        $saldoFavor->curso_name = $transaction->curso_name;
        $saldoFavor->saldo_id = 0;
        $saldoFavor->save();
        // $this->destroy();


        // Se crea el registro en la tabla transacciones con la información del saldo a favor
        $transaccion = new Transaction();
        $transaccion->date = Carbon::now()->toDateString();
        $transaccion->name = $saldoFavor->name;
        $transaccion->transaction = "Saldo a Favor";
        $transaccion->number = $saldoFavor->id;
        $transaccion->quantity = 1;
        $transaccion->descuento = $saldoFavor->descuento;
        $transaccion->subtotal = $saldoFavor->subtotal;
        $transaccion->impuestos = $saldoFavor->impuestos;
        $transaccion->detail = "Creación: SALDO A FAVOR  (Devolucion " . $saldoFavor->id . ") (transacción vigente ) cliente: " . $saldoFavor->name;
        $transaccion->total = $saldoFavor->total;
        $transaccion->observation = "N/A";
        $transaccion->status = 1;
        $transaccion->devolucion_id = $transaction->devolucion_id;
        $transaccion->order_id = $transaction->order_id;
        $transaccion->student_id = $transaction->student_id;
        $transaccion->instructor_id = $transaction->instructor_id;
        $transaccion->instructor_name = $transaction->instructor_name;
        $transaccion->curso_id = $transaction->curso_id;
        $transaccion->curso_name = $transaction->curso_name;
        $transaccion->saldo_id = $saldoFavor->id;
        $transaccion->save();
        // $this->destroy();
        //Se actualiza el estado de la order y el registro de la tabla "transaction"
        $this->updateTransactionOrder($transaction->order_id);
        // se redirecciona a la ruta 'afiliados.financiero' con el fin  de actualizar la información de la vista
        redirect()->route('admin.financiero');
    }

    private function updateTransactionOrder($torder)
    {
        // Actualizar el campo 'status' en la tabla 'orders' filtrado por 'order_id'
        $order = Order::find($torder);
        // Order::where('id', $torder)
        if ($order) {
            $order->update([
                'status' => 5,
                'observation' => str_replace("exitosa", "Anulada", $order->observation)
            ]);
        }
        //     ->update(['status' => 5,
        //               'observation' =>  str_replace("exitosa", "Anulada", $torder->observation)
        // ]);

        // Actualizar el campo 'status' en la tabla 'transactions' filtrado por 'order_id' y por el campo 'transaction'
        Transaction::where('order_id', $torder)
            ->where('transaction', 'Venta')
            ->update(['status' => 5]);

        // Actualizar el campo 'detail' en las transacciones para reemplazar 'exitosa' por 'Anulada'
        $transactions = Transaction::where('order_id', $torder)
            ->where('transaction', 'Venta')
            ->get();

        foreach ($transactions as $transaction) {
            $transaction->detail = str_replace("exitosa", "Anulada", $transaction->detail);
            $transaction->save();
        }
    }

    public function render()
    {
        $transacciones = Transaction::query();

        // Aplicar filtros seleccionados
        if (!empty($this->filtrosSeleccionados)) {
            $transacciones->whereIn('transaction', $this->filtrosSeleccionados);
        }

        $transacciones = $transacciones->get();

        return view('livewire.admin.financiero', [
            'transactions' => $transacciones,
        ]);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedTransactions = $this->transactions->filter(function ($transaction) {
                return $transaction->transaction == 'Venta' && $transaction->status == 6  && $transaction->auxstatus == 1;
            })->map(function ($transaction) {
                return json_encode($transaction);
            })->toArray();
        } else {
            $this->selectedTransactions = [];
        }
    }


    public function isSelected($transaction)
    {
        return collect($this->selectedTransactions)->contains(json_encode($transaction));
    }

    public function toggleSelection($transaction)
    {
        $transaction = (array) $transaction;
        if ($this->isSelected($transaction)) {
            $this->selectedTransactions = collect($this->selectedTransactions)->reject(function ($item) use ($transaction) {
                return $item['id'] === $transaction['id'];
            })->toArray();
        } else {
            $this->selectedTransactions[] = $transaction;
        }
    }

    public function pagarSeleccionados()
    {
        if (empty($this->selectedTransactions)) {
            $this->emit('alert', ['type' => 'error', 'message' => 'No hay transacciones seleccionadas.']);
            return;
        }

        $transactions = collect($this->selectedTransactions)->map(function ($item) {
            return json_decode($item);
        });

        $instructors = $transactions->pluck('instructor_name')->unique();

        if ($instructors->count() > 1) {
            $this->emit('alert', ['type' => 'error', 'message' => 'No se pueden seleccionar transacciones con distintos instructores.']);
            return;
        }

        try {
            // Obtener el último número de comprobante registrado, si existe alguno
            $ultimoNumeroComprobante = comprobante_pago::max('numero');

            // Si no hay ningún comprobante registrado, asignar el número 1 como valor inicial
            $ultimoNumeroComprobante = $ultimoNumeroComprobante ?? 0;

            // Crear y guardar el comprobante de pago
            $comprobantePago = new comprobante_pago();
            $comprobantePago->persona_id = $transactions->first()->instructor_id;
            $comprobantePago->numero = $ultimoNumeroComprobante + 1;
            $comprobantePago->nombre =  $transactions->first()->instructor_name;
            $comprobantePago->fecha_elaboracion = Carbon::now()->toDateString();
            $comprobantePago->user_id = auth()->user()->id;
            $comprobantePago->status = 6;
            $comprobantePago->total = $transactions->sum('total');
            $comprobantePago->observacion = "NA";
            $comprobantePago->save();

            $orderNumbers = [];

            foreach ($transactions as $transaction) {
                $comprobantePagoDetalle = new comprobante_pago_detalle();
                $comprobantePagoDetalle->comprobante_pago_id = $comprobantePago->id;
                $comprobantePagoDetalle->order_id = $transaction->order_id;
                $comprobantePagoDetalle->curso_id = $transaction->curso_id;
                $comprobantePagoDetalle->curso_name = $transaction->curso_name;
                $comprobantePagoDetalle->observacion = "NA";
                $comprobantePagoDetalle->total = $transaction->total;
                $comprobantePagoDetalle->save();

                // Recopilar los números de las órdenes para el detalle
                $orderNumbers[] = $transaction->number;

                // Actualizar el campo auxstatus de la transacción
                Transaction::where('id', $transaction->id)->update(['auxstatus' => 6]);
            }

            // Crear un string con los números de las órdenes
            $orderNumbersString = implode(', ', $orderNumbers);


            // Actualizar la observacion del comprobante de pago
            comprobante_pago::where('id', $comprobantePago->id)->update(['observacion' => "Creación: COMPROBANTE DE PAGO ( Órdenes: " . $orderNumbersString . ") (transacción exitosa)"]);

            // Crear el registro en la tabla transacciones con la información del comprobante de pago
            $transaccion = new Transaction();
            $transaccion->date = Carbon::now()->toDateString();
            $transaccion->name = $comprobantePago->nombre; // corregido
            $transaccion->transaction = "Comprobante Pago";
            $transaccion->number = $comprobantePago->numero;
            $transaccion->quantity = 1;
            $transaccion->descuento = 0;
            $transaccion->subtotal = $comprobantePago->total;
            $transaccion->impuestos = 0;
            $transaccion->detail = "Creación: COMPROBANTE DE PAGO ( Órdenes: " . $orderNumbersString . ") (transacción exitosa)";
            $transaccion->total = $comprobantePago->total;
            $transaccion->observation = "N/A";
            $transaccion->status = 6;
            $transaccion->devolucion_id = 0;
            $transaccion->order_id = 0;
            $transaccion->student_id = 0;
            $transaccion->instructor_id = 0;
            $transaccion->instructor_name = "NA";
            $transaccion->curso_id = 0;
            $transaccion->curso_name = "NA";
            $transaccion->saldo_id = 0;
            $transaccion->save();

            $this->emit('alert', ['type' => 'success', 'message' => 'Pago realizado correctamente.']);
            $this->selectedTransactions = [];
            $this->transactions = Transaction::all(); // Refresca la lista de transacciones
        } catch (\Exception $e) {
            $this->emit('alert', ['type' => 'error', 'message' => 'Ocurrió un error al procesar el pago: ' . $e->getMessage()]);
        }
    }
}
