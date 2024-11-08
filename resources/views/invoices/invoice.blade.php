<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura #{{ $sale->id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #333;
            font-size: 0.8em;
            background-image: url('{{ public_path('assets/img/marca.png') }}');
            background-size: cover; /* Adjust this as needed */
            background-position: center;
            background-repeat: no-repeat;
            background-opacity: 0.1; /* Adjust opacity if supported by PDF renderer */
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            font-size: 0.8em;
        }

        th {
            color: #333;
            font-weight: bold;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .company-name {
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 5px;
        }

        .company-info {
            text-align: right;
            line-height: 1.5;
        }

        .total {
            font-weight: bold;
            text-align: right;
            font-size: 1em;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            color: #888;
            font-size: 0.7em;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        h3 {
            margin-top: 20px;
            font-weight: 700;
            font-size: 1.2em;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        .distributor-info {
            font-size: 0.9em;
            color: #555;
            margin-bottom: 5px;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 5px;
        }

        .logo-container img {
            width: 40px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <table style="border-width: 0px">
            <tr style="border-width: 0px">
                <td style="border-width: 0px; font-weight: bold; font-size: 1.2em;">
                    <div class="company-name">
                        <img width="150" src="{{ public_path('assets/img/force-logo.png') }}" alt="force">
                    </div>
                    <div style="font-size: 0.5em; color: #555"><small>Distribuidores de:<br><br></small></div>
                    <div class="logo-container">
                        <img src="{{ public_path('assets/img/logos/baldwin.png') }}" alt="baldwin">
                        <img src="{{ public_path('assets/img/logos/donsson.png') }}" alt="donsson">
                        <img src="{{ public_path('assets/img/logos/fleetguard.png') }}" alt="fleetguard">
                        <img src="{{ public_path('assets/img/logos/parker-racor.png') }}" alt="parker-racor">
                        <img src="{{ public_path('assets/img/logos/sakura.png') }}" alt="sakura">
                    </div>
                </td>
                <td style="border-width: 0px">
                    <div class="company-info">
                        Email: forcefilters1@gmail.com<br>
                        Teléfono: +57 318 8366586 <br>
                        http://wwww.forcefilters.com
                    </div>
                </td>
            </tr>
        </table>
        
        <table>
            <tr>
                <th>N° Factura: </th>
                <td colspan="3">{{ $sale->invoice_number }}</td>
            </tr>
            <tr>
                <th>Fecha de compra: </th>
                <td>{{ \Carbon\Carbon::parse($sale->order_date)->format('d/m/Y') }}</td>
                <th>Hora de compra: </th>
                <td>{{ \Carbon\Carbon::parse($sale->order_date)->format('h:i A') }}</td>
            </tr>
            <tr>
                <th>Forma de pago: </th>
                <td>
                    @if ($sale->payment_mode === 'cash')
                        Contado
                    @elseif($sale->payment_mode === 'credit')
                        Crédito ({{ $sale->payment_term }} dias)
                    @else
                        Sin especificar
                    @endif
                </td>
                <th>Fecha límite de pago: </th>
                <td>{{ $sale->due_date ?? 'No aplica' }}
                </td>
            </tr>
        </table>

        <h3>Detalles del cliente:</h3>
        <table>
            <tr>
                <th>Número de identificación: </th>
                <td>{{ strtoupper($sale->customer->identification ?? 'N/A') }}</td>
            </tr>
            <tr>
                <th>Cliente: </th>
                <td>{{ strtoupper($sale->customer->name ?? 'N/A') }}</td>
            </tr>
            <tr>
                <th>Dirección: </th>
                <td>{{ strtoupper($sale->customer->address ?? 'N/A') }}</td>
            </tr>
            <tr>
                <th>Teléfono: </th>
                <td>{{ strtoupper($sale->customer->phone ?? 'N/A') }}</td>
            </tr>
            <tr>
                <th>Correo Electrónico: </th>
                <td>{{ strtoupper($sale->customer->email ?? 'N/A') }}</td>
            </tr>
        </table>

        <h3>Detalles de la compra:</h3>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Precio Unitario</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->product->description }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-right">{{ number_format($item->total_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">Total: ${{ number_format($sale->total_amount, 2) }}</div>
    </div>

    <div class="footer">
        &copy; <span id="currentYear"></span> FORCE FILTERS. Todos los derechos reservados.
    </div>

    <script>
        document.getElementById('currentYear').innerText = new Date().getFullYear();
    </script>
</body>

</html>