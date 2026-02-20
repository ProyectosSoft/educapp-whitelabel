<!DOCTYPE html>
<html>

<head>
    <title>Factura de Venta</title>
    <style>
        /* Estilos CSS para el PDF */
        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }

        .max-w-4xl {
            max-width: 48rem;
            /* 768px */
            margin: auto;
            padding: 1.5rem;
            background: #fff;
            box-shadow: 0 0 1rem rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
        }

        .flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .p-2 {
            padding: 0.5rem;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }

        .font-semibold {
            font-weight: 600;
        }

        .text-4xl {
            font-size: 2.25rem;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .border {
            border: 1px solid #ddd;
        }

        .border-b {
            border-bottom: 1px solid #ddd;
        }

        .bg-blue-500 {
            background-color: #4299e1;
        }

        .text-blue-500 {
            color: #4299e1;
        }

        .text-white {
            color: #fff;
        }

        .w-full {
            width: 100%;
        }
    </style>
</head>


<body>
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-md">
        <div class="flex justify-between items-center mb-6">
            <div class="text-right">
                <h1 class="text-4xl font-bold">FACTURA DE VENTA</h1>
                <p>Número: <span class="font-semibold">{{ $order->id }}</span></p>
                {{-- <p>Fecha: <span class="font-semibold">{{ $dorder->created_at }}</span></p> --}}
                <p>Estado: <span class="font-semibold">
                        @switch($order->status)
                            @case(1)
                                Pendiente
                            @break

                            @case(2)
                                Recibido
                            @break

                            @case(3)
                                Enviado
                            @break

                            @case(4)
                                Reembolso
                            @break

                            @case(5)
                                Anulada
                            @break

                            @case(6)
                                Pagada
                            @break

                            @default
                        @endswitch
                    </span></p>
            </div>
        </div>
        <div class="mb-6">
            <p class="font-semibold">Nombre:</p>
            <p>{{ $order->contact }}</p>
        </div>
        <table class="w-full mb-2 border-collapse">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="p-2 border">NO.</th>
                    <th class="p-2 border">DESCRIPCIÓN DEL CURSO</th>
                    <th class="p-2 border">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $index => $detalle)
                    <tr class="border-b">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $detalle->curso_name }}</td>
                        <td>{{ number_format($detalle->total) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mb-2">
            <table class="w-full mb-6 border-collapse">
                <thead>
                    <tr class="bg-blue-500 text-white">
                        <th class="p-2 border">OBSERVACIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="p-2 border">{{ $order->observation }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mb-2">
            <div class="text-right">
                <p>Subtotal: <span class="font-semibold">{{ number_format($order->total) }}</span></p>
                <!-- Puedes agregar descuentos e impuestos si los tienes -->
                <p class="text-xl font-bold">Total: <span>{{ number_format($order->total) }}</span></p>
            </div>
        </div>
    </div>
</body>

</html>
