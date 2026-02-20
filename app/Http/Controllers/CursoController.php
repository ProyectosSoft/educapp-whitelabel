<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Curso;
use App\Models\Order;
use App\Models\Devolucion;
use App\Models\DevolucionItem;
use App\Mail\SolicitarReembolso;
use App\Models\Transaction;

class CursoController extends Controller
{
    public function index()
    {
        return view('cursos.index');
    }

    public function show(Curso $course)
    {

        // $this->authorize('published',$course);

        $similares = Curso::where('categoria_id', $course->categoria_id)
            ->where('id', '!=', $course->id)
            // ->where('status',3)
            ->latest('id')
            ->take(5)
            ->get();

        if (auth()->user()) {
            //Obtén informacion de los dias de la garantia
            $diasGarantia = $course->garantia->valor;
            // Obtén solo la fecha de matrícula del usuario actual para este curso
            $fechaMatriculaArray = $course->students()->wherePivot('user_id', auth()->user()->id)->pluck('curso_user.created_at')->first();

            // Verifica si $fechaMatriculaArray es una cadena válida
            if ($fechaMatriculaArray !== null) {
                // Si es una cadena válida, conviértela a un objeto Carbon
                $fechaMatricula = Carbon::parse($fechaMatriculaArray);
                // Calcula los días que han pasado entre $fechaMatricula y la fecha actual
                $diasPasados = $fechaMatricula->diffInDays(Carbon::now());
            } else {
                // Si la fecha de matrícula no está definida, establece $diasPasados en 0
                $diasPasados = 0;
            }
            // si los diasGrantia es mayor que los diasPasados la garantia es valida permite el reembolso, sino la garantia ya no es valida y no permite el reembolso
            if ($diasGarantia > $diasPasados) {
                $garantiaValida = true;
            } else {
                $garantiaValida = false;
            }
        } else {
            $garantiaValida = false;
        }
        return view('cursos.show', compact('course', 'similares', 'garantiaValida'));
    }

    public function matriculado(Curso $course)
    {
        $course->students()->attach(auth()->user()->id);
        return redirect()->route('cursos.status', $course);
    }

    /*public function status(Curso $course){
        return view('cursos.status',compact('course'));
    }*/

    public function image(Curso $course)
    {
        return view('cursos.image', compact('course'));
    }

    public function solicitarReembolso(Curso $course)
    {
        $selectedCourseId = $course->id;
        // Recuperar los detalles de la roden de compra
        // $orderItems = $course->orderItems;

        // Ahora, realiza la consulta para obtener la orden del usuario activo que contiene el curso seleccionado
        $order = Order::where('user_id', auth()->user()->id)
            ->whereHas('items', function ($query) use ($selectedCourseId) {
                $query->where('curso_id', $selectedCourseId);
            })
            ->where('status', 6)
            ->first();

        $this->ActualizarOrden_Transaccion($order);
        //Traer OrderItems
        $orderItems = $order->items;
        // dump($orderItems);

        // Crear una nueva instancia de devolución
        $devolucion = new Devolucion();
        $devolucion->user_id = auth()->id();
        $devolucion->contact = $order->contact;
        $devolucion->phone = $order->phone;
        $devolucion->status = 1;
        $devolucion->total = $order->total;
        $devolucion->observation = "NA";
        $devolucion->save();


        foreach ($orderItems as $orderItem) {

            // Crear una nueva instancia de devolución de ítems para cada elemento de pedido
            $devolucionItems = new DevolucionItem();
            $devolucionItems->price = $orderItem->price;
            $devolucionItems->nombre = $orderItem->nombre;
            $devolucionItems->currency = $orderItem->currency;
            $devolucionItems->quantity = $orderItem->quantity;
            $devolucionItems->descuento = $orderItem->descuento;
            $devolucionItems->subtotal = $orderItem->subtotal;
            $devolucionItems->impuestos = $orderItem->impuestos;
            $devolucionItems->total = $orderItem->total;
            $devolucionItems->curso_id = $orderItem->curso_id;
            $devolucionItems->curso_name = $orderItem->curso_name;
            $devolucionItems->instructor_id = $orderItem->instructor_id;
            $devolucionItems->instructor_name = $orderItem->instructor_name;
            $devolucionItems->devolucion_id = $devolucion->id;
            $devolucionItems->save();

            $transaccion = new Transaction();
            $transaccion->date = Carbon::now()->toDateString();
            $transaccion->name = $order->contact;
            $transaccion->transaction = "Devolucion";
            $transaccion->quantity = $orderItem->quantity;
            $transaccion->descuento = $orderItem->descuento;
            $transaccion->subtotal = $orderItem->subtotal;
            $transaccion->impuestos = $orderItem->impuestos;
            $transaccion->number = $devolucion->id;
            $transaccion->detail = "Creación: DEVOLUCIÓN DE VENTA (orden de venta " . $orderItem->order_id . " ) (transacción vigente ) " . " Cliente: " . $order->contact;
            $transaccion->total = $order->total;
            $transaccion->observation = "N/A";
            $transaccion->status = 1;
            $transaccion->devolucion_id = $devolucion->id;
            $transaccion->order_id = $order->id;
            $transaccion->student_id = auth()->user()->id;
            $transaccion->student_id = auth()->user()->id;
            $transaccion->instructor_id = $orderItem->instructor_id;
            $transaccion->instructor_name = $orderItem->instructor_name;
            $transaccion->curso_id = $orderItem->curso_id;
            $transaccion->curso_name = $orderItem->curso_name;
            $transaccion->saldo_id = 0;
            $transaccion->save();
        }
        //Enviar correo electronico
        $mail = new SolicitarReembolso($course->students()->where('users.id', auth()->user()->id)->pluck('name')->first(), $course);
        $email = $course->students()->where('users.id', auth()->user()->id)->pluck('email')->first();
        Mail::to($email)->queue($mail);

        // Eliminar al estudiante del curso
        $course->students()->detach(auth()->user()->id);
        // Actualizar la observacion de la devolucion
        Devolucion::where('id', $devolucion->id)->update(['observation' => "Creación: DEVOLUCIÓN DE VENTA (orden de venta " . $orderItem->order_id . " ) (transacción vigente ) " . " Cliente: " . $order->contact]);
        return redirect()->route('home');
    }

    private function ActualizarOrden_Transaccion($order)
    {
        $orders = Order::where('id', $order->id)->get();
        foreach ($orders as $order) {
            $order->status = 4;
        }
        Order::where('id', $order->id)->update(['status' => 4]);

        $transaction = Transaction::where('devolucion_id', 0)
            ->where('saldo_id', 0)
            ->where('order_id', $order->id)
            ->first(['id']);

        if ($transaction) {
            // Actualizar el campo 'status' de la transacción
            $transaction->status = 4;  // Suponiendo que el nuevo estado es 6
            $transaction->save();
        }
    }
}
