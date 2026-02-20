<?php

namespace App\Http\Controllers;

use App\Models\SaldoFavor;
use App\Models\Devolucion;
use App\Models\Order;
use App\Models\comprobante_pago;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function verReporte($transactionNumber)
    {
        // $comprobantePago=comprobante_pago::All();

        $comprobantePago = comprobante_pago::where('numero', $transactionNumber)->firstOrFail();

        // $pdf = PDF::loadView('admin.dashboard.comprobante_de_pago', compact('comprobantePago'));
        $pdf = PDF::loadView('admin.dashboard.comprobante_de_pago', compact('comprobantePago'))->setPaper('letter', 'landscape');

        // Retornar el PDF como respuesta (puedes ajustarlo según tus necesidades)
        return $pdf->stream('comprobante_pago.pdf');
    }

    public function verReporte_factura($transactionNumber)
    {
        // $comprobantePago=comprobante_pago::All();

        $order = Order::where('id', $transactionNumber)->firstOrFail();

        // $pdf = PDF::loadView('admin.dashboard.comprobante_de_pago', compact('comprobantePago'));
        $pdf = PDF::loadView('documentosfinancieros.factura_venta', compact('order'))->setPaper('letter', 'landscape');

        // Retornar el PDF como respuesta (puedes ajustarlo según tus necesidades)
        return $pdf->stream('factura_venta.pdf');
    }

    public function verReporte_saldofavor($transactionNumber)
    {
        // $comprobantePago=comprobante_pago::All();

        $saldofavor = SaldoFavor::where('id', $transactionNumber)->firstOrFail();

        // $pdf = PDF::loadView('admin.dashboard.comprobante_de_pago', compact('comprobantePago'));
        $pdf = PDF::loadView('documentosfinancieros.saldo_favor', compact('saldofavor'))->setPaper('letter', 'landscape');

        // Retornar el PDF como respuesta (puedes ajustarlo según tus necesidades)
        return $pdf->stream('Saldo A Favor.pdf');
    }
    public function verReporte_devolucion($transactionNumber)
    {
        // $comprobantePago=comprobante_pago::All();

        $devolucion = Devolucion::where('id', $transactionNumber)->firstOrFail();

        // $pdf = PDF::loadView('admin.dashboard.comprobante_de_pago', compact('comprobantePago'));
        $pdf = PDF::loadView('documentosfinancieros.devolucion', compact('devolucion'))->setPaper('letter', 'landscape');

        // Retornar el PDF como respuesta (puedes ajustarlo según tus necesidades)
        return $pdf->stream('devolucion.pdf');
    }
}
