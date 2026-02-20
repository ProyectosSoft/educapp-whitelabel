<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\CarList;
use App\Models\Cupon;
use App\Models\Transaction;
use Carbon\Carbon;
use App\Models\SaldoFavor;
use Gloudemans\Shoppingcart\Facades\Cart;


class CreateOrder extends Component
{
    public $contact, $phone, $carlist, $total, $total2, $descuento;
    public $saldosAFavor; // Agregar esta propiedad para almacenar los saldos a favor del usuario
    public $successMessage;
    public $errorMessage;
    public $subtotal;
    public $saldoAplicado;

    public $rules = [
        'contact' => 'required',
        'phone' => 'required'
    ];

    public $discountValue = 0;
    public $valordescuento = 99;
    public $totalSaldo;
    public $saldoFavor;

    public function mount()
    {

        $this->totalSaldo = SaldoFavor::where('student_id', auth()->user()->id)->sum('saldo_restante');
        $this->carlist = CarList::where('user_id', auth()->user()->id)->get();
        $this->saldosAFavor = SaldoFavor::where('student_id', auth()->user()->id)
            ->where('status', 1)
            ->get(); // Cargar los saldos a favor del usuario
    }
    public function render()
    {
        if (auth()->user()) {
            // $this->totalSaldo = number_format(SaldoFavor::sum('total'), 0, '.', ',');
            $this->carlist = CarList::where('user_id', auth()->user()->id)->where('estado', 1)->get();
            $this->descuento = CarList::where('user_id', auth()->user()->id)->where('estado', 1)->sum('descuento');
            $this->contact = auth()->user()->name;
            $this->calculateTotal();
        }

        return view('livewire.create-order');
    }
    public function calculateTotal()
    {
        $this->subtotal = $this->carlist->sum('total');
        $total = $this->subtotal - $this->totalSaldo - $this->descuento;
        if ($this->subtotal == $this->totalSaldo) {
            $this->total2 = ($total < 0) ? $total * -1 : (($total == 0) ? 0 : $total);
        } else {
            $this->total2 = ($total < 0) ? 0 : (($total == 0) ? $total * -1 : $total);
        }
        $this->saldoAplicado = $this->subtotal - $this->total2;
        $this->total = $total > 0 ? $total : 0;
    }
    public function create_order()
    {
        // Validar los campos
        $this->validate();
        $carList = CarList::where('user_id', auth()->user()->id)->where('estado', 1)->get();
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->contact = $this->contact;
        $order->phone = $this->phone;
        if ($this->totalSaldo != 0) {
            $order->saldo_favor = $this->saldoAplicado;
            if ($order->saldo_favor < 0) {
                $order->saldo_favor = 0;
            }
        } else {
            $order->saldo_favor = 0;
        }
        $order->subtotal = $this->subtotal;
        $order->total = $this->total;
        $order->observation = "NA";
        $order->save();

        foreach ($carList as $carItem) {
            $orderItem = new OrderItems();
            $orderItem->order_id = $order->id;
            $orderItem->currency = $carItem->currency;
            $orderItem->nombre = $carItem->nombre;
            $orderItem->descuento = $carItem->descuento;
            $orderItem->subtotal = $carItem->subtotal;
            $orderItem->impuestos = $carItem->impuestos;
            $orderItem->total = $carItem->total;
            $orderItem->curso_id = $carItem->curso_id;
            $orderItem->curso_name = $carItem->curso_name; // Suponiendo que 'curso_id' es el campo que contiene el ID del producto en CarList
            $orderItem->instructor_id = $carItem->instructor_id;
            $orderItem->instructor_name = $carItem->instructor_name;
            $orderItem->quantity = 1; // Suponiendo que la cantidad es siempre 1 por cada elemento en CarList
            $orderItem->price = $carItem->price; // Suponiendo que 'price' es el campo que contiene el precio del producto en CarList

            // Guardar el OrderItem y validar que se guardó correctamente
            if (!$orderItem->save()) {
                // Manejar el error de guardado del OrderItem
                // Por ejemplo, puedes eliminar la orden creada anteriormente y redirigir al formulario con un mensaje de error
                $order->delete();
                return redirect()->back()->with('error', 'Error al guardar los detalles de la orden.');
            }

            $transaccion = new Transaction();
            $transaccion->date = Carbon::now()->toDateString();
            $transaccion->name = auth()->user()->name;
            $transaccion->transaction = "Venta";
            $transaccion->number = $order->id;
            $transaccion->quantity = 1;
            $transaccion->descuento = $carItem->descuento;
            $transaccion->subtotal = $carItem->subtotal;
            $transaccion->impuestos = $carItem->impuestos;
            //se valida acá si la orden se hace con saldo, para que no altere el pago al instructor
            if ($this->totalSaldo == 0) {
                $transaccion->total = $order->total;
            } else {
                $transaccion->total = $carItem->total;
            }
            $transaccion->observation = "N/A";
            //Se valida si el estudiante no tuvo que realizar un pago ya que pudo tener un descuento o un saldo a favor
            if ($order->total == 0) {
                $transaccion->status = 6;
                $transaccion->detail = "Creación: ORDEN DE VENTA " . $order->id . " (transacción exitosa ) " . " Cliente: " . auth()->user()->name;
            } else {
                $transaccion->status = 1;
                $transaccion->detail = "Creación: ORDEN DE VENTA " . $order->id . " (transacción vigente ) " . " Cliente: " . auth()->user()->name;
            }
            $transaccion->devolucion_id = 0;
            $transaccion->order_id = $order->id;
            $transaccion->student_id = auth()->user()->id;
            $transaccion->instructor_id = $carItem->instructor_id;
            $transaccion->instructor_name = $carItem->instructor_name;
            $transaccion->curso_id = $carItem->curso_id;
            $transaccion->curso_name = $carItem->curso_name;
            $transaccion->saldo_id = 0;
            $transaccion->save();
        }


        // Actualizar la observacion de la order
        Order::where('id', $order->id)->update(['observation' => $transaccion->detail]);
        $this->applySaldoAFavor($order);
        $this->destroy();
        return redirect()->route('orders.payment', $order);
    }

    private function applySaldoAFavor($order)
    {
        $saldoUsado = 0;
        foreach ($this->saldosAFavor as $saldo) {
            if ($saldoUsado < $this->saldoAplicado) {
                if ($this->saldoAplicado >= $saldo->saldo_restante) {
                    $saldo->saldo_restante = 0;
                    $saldoUsado += $this->saldoAplicado;
                    $saldo->status = 6;
                }
                if ($this->saldoAplicado < $saldo->saldo_restante) {
                    $sr = $saldo->saldo_restante;
                    $saldo->saldo_restante = $sr - $this->saldoAplicado;
                    $saldoUsado += $this->saldoAplicado;
                }
                $saldo->detail =  $saldo->detail . "\nAplicado en ORDEN DE VENTA " . $order->id . " Valor: " . number_format(($saldo->total - $saldo->saldo_restante), 0, ',', '.') . " (Fecha: " . Carbon::now() . ")";
                $order->saldosAFavor()->attach($saldo->id);
                $saldo->save();
                $this->updateTransactionSaldo($saldo, $order);
            }
        }
    }

    private function updateTransactionSaldo($saldo, $order)
    {
        $transactions = Transaction::where('saldo_id', $saldo->id)->get();
        // Actualizar el campo 'detail' en las transacciones para reemplazar 'vigente' por 'pagada'
        foreach ($transactions as $transaction) {
            if ($saldo->status == 6) {
                $transaction->status = 6;
            }
            // $transaction->detail = $transaction->detail .  " Aplicado en ORDEN DE VENTA " . $order->id ."Valor: ". ($saldo->total - $saldo->saldo_restante)." (Fecha: ". Carbon::now()." ) ";
            $transaction->detail = $transaction->detail . "\nAplicado en ORDEN DE VENTA " . $order->id . " Valor: " . number_format(($saldo->total - $saldo->saldo_restante), 0, ',', '.') . " (Fecha: " . Carbon::now() . ")";
            $transaction->save();
        }
    }
    public function applyDiscount()
    {
        $invalidCourses = []; // Arreglo para almacenar los nombres de los cursos no válidos/ Variable para contar cuántos cupones válidos se han encontrado
        // Buscar el cupón por el código y las fechas
        $cupon = Cupon::where('codigo', $this->discountValue)
            ->where('estado', 1) // Filtrar por estado activo del cupón
            ->whereDate('fecha_inicio', '<=', now()->startOfDay()) // Verificar fecha de inicio
            ->whereDate('fecha_fin', '>=', now()->endOfDay()) // Verificar fecha de fin
            ->first();

        // Verificar si no se encontró el cupón
        if (!$cupon) {
            $this->errorMessage = 'No se encontró un descuento válido para este cupón.';
            return;
        }

        // Verificar si el cupón ha expirado
        if ($cupon->fecha_fin <= now()->endOfDay()) {
            // Desactivar el cupón
            $cupon->estado = 0;
            $cupon->save();
            $this->errorMessage = 'El disponible.';
            // $this->errorMessage = 'El cupón ha expirado y ya no está disponible.';
            return;
        }

        // Buscar el carro de compras del usuario actual
        $carList = CarList::where('user_id', auth()->user()->id)->where('estado', 1)->get();

        // Verificar si se encontraron elementos en el carro de compras
        if ($carList->isEmpty()) {
            $this->errorMessage = 'No se encontraron elementos en el carro de compras.';
            return;
        }

        // Iterar sobre cada elemento del carro de compras para aplicar el descuento
        foreach ($carList as $car) {
            //Verificar si los cursos ya se le han aplicados descuentos
            if ($car->descuento == 0) {
                // Verificar si el curso del elemento coincide con el ID del curso del cupón
                if ($car->curso_id == $cupon->curso_id) {
                    // Aplicar el descuento al precio del carro de compra
                    $this->total -= $cupon->valor;
                    $this->descuento = $cupon->valor;
                    $car->total -= $cupon->valor;
                    $car->descuento = $cupon->valor;
                    $car->cupon_id = $cupon->id;
                    // Guardar los cambios en la base de datos
                    $car->save();

                    // Verificar si el cupón ha alcanzado su límite de uso por cantidad
                    if ($cupon->cantidad != 0) {
                        $appliedCouponCount = CarList::where('user_id', auth()->user()->id)
                            ->where('cupon_id', $cupon->id)
                            ->count();

                        if ($appliedCouponCount >= $cupon->cantidad) {
                            // Desactivar el cupón
                            $cupon->estado = 0;
                            $cupon->save();

                            $this->errorMessage = 'El cupón ha alcanzado su límite de uso.';
                            return;
                        }
                    }
                    // Mostrar un mensaje de éxito
                    $this->successMessage = 'Cupón aplicado correctamente.';
                } else {
                    // Almacenar el nombre del curso en el arreglo de cursos no válidos
                    $invalidCourses[] = $car->nombre;
                }
            } else {
                // Almacenar el nombre del curso en el arreglo de cursos no válidos
                $invalidCourses[] = $car->nombre;
            }
        }

        // Verificar si no se encontraron cupones válidos
        if (!empty($invalidCourses)) {
            // Convertir el arreglo de nombres de cursos en una cadena separada por comas
            $invalidCoursesString = implode(', ', $invalidCourses);
            // Mostrar un mensaje indicando los cursos para los cuales el cupón no es válido
            $this->errorMessage = "El cupón no aplica para los siguientes cursos:" . $invalidCoursesString;
            return;
        }
        // Emitir un evento para indicar que se aplicó el descuento
        // $this->emit('descuentoAplicado', $cupon->valor);
        $this->calculateTotal(); // Recalcular los totales después de aplicar el descuento
        $this->emit('discountApplied', $this->total, $this->subtotal, $this->saldoAplicado, $this->descuento); // Emitir
    }

    public function destroy()
    {
        // Vaciar completamente el carrito de compras por usuario
        if (auth()->user()) {
            // Obtener el ID del usuario autenticado
            $userId = auth()->user()->id;

            // Actualizar el campo 'estado' a 6 para los items del carro de compras del usuario
            CarList::where('user_id', $userId)->update(['estado' => 6]);
        }
        // Emitir evento para actualizar la vista del carrito
        $this->emitTo('dropdown-cart', 'render');
        $this->emitTo('span-cart', 'render');
    }
}
