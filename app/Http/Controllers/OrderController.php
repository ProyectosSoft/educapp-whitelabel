<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::query()->where('user_id', auth()->user()->id);
        if (request('status')) {
            $orders->where('status', request('status'));
        }
        $orders = $orders->get();

        $pendiente = Order::where('status', 1)->where('user_id', auth()->user()->id)->count();
        $pagada = Order::where('status', 2)->where('user_id', auth()->user()->id)->count();
        $cancelada = Order::where('status', 3)->where('user_id', auth()->user()->id)->count();
        $rechazada = Order::where('status', 4)->where('user_id', auth()->user()->id)->count();

        return view('orders.index', compact('orders', 'pendiente', 'pagada', 'cancelada', 'rechazada'));
    }

    public function show(Order $order)
    {
        $this->authorize('author', $order);

        $items = $order->items;
        // $items=json_decode($order->content );
        return view('orders.show', compact('order', 'items'));
    }

    public function payment(Order $order)
    {
        $items = $order->items;
        // $items=json_decode($order->content );
        return view('orders.payment', compact('order', 'items'));
    }



    public function pay(Order $order, Request $request)
    {
        $payment_id = $request->get('payment_id');

        $response = Http::get("https://api.mercadopago.com/v1/payments/$payment_id" . "?access_token=" . config('services.mercadopago.token'));

        $response = json_decode($response);

        $status = $response->status;

        if ($status == 'approved') {
            $order->status = 6;
            $order->observation = str_replace("vigente", "exitosa", $order->observation);
            $order->save();

            // Actualizar el campo 'status' en la tabla 'transactions' filtrado por 'order_id'
            Transaction::where('order_id', $order->id)
                ->update(['status' => 6]);

            // Actualizar el campo 'detail' en las transacciones para reemplazar 'vigente' por 'pagada'
            $transactions = Transaction::where('order_id', $order->id)->get();
            foreach ($transactions as $transaction) {
                $transaction->detail = str_replace("vigente", "exitosa", $transaction->detail);
                $transaction->save();
            }

            // Matricular al estudiante en cada curso asociado a los items de la orden-
            // dump($order->items);
            foreach ($order->items as $orderItem) {
                $course = $orderItem->curso; // Suponiendo que haya una relación entre OrderItem y Course
                if ($course) {
                    $course->students()->attach(auth()->user()->id);
                }
            }
        }
        return redirect()->route('orders.show', $order);
    }

    public function zeroPayment(Order $order)
    {

        //Verifica que el id de la orden sea diferente de cero
        if ($order->id != 0) {
            $order->status = 6; // Esartdoo de pago completado
            $order->save();

            // Actualizar el campo 'status' en la tabla 'transactions' filtrado por 'order_id'
            Transaction::where('order_id', $order->id)
                ->update(['status' => 6]);

            // Actualizar el campo 'detail' en las transacciones para reemplazar 'vigente' por 'pagada'
            $transactions = Transaction::where('order_id', $order->id)->get();
            foreach ($transactions as $transaction) {
                $transaction->detail = str_replace("vigente", "exitosa", $transaction->detail);
                $transaction->save();
            }

            // Matricular al estudiante en cada curso asociado a los items de la orden-
            // dump($order->items);
            foreach ($order->items as $orderItem) {
                $course = $orderItem->curso; // Suponiendo que haya una relación entre OrderItem y Course
                if ($course) {
                    $course->students()->attach(auth()->user()->id);
                }
            }
        }
        return redirect()->route('orders.show', $order);
    }
}
