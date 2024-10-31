<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura #{{ $sale->id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Estilos básicos para la factura */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            /* Fondo blanco */
            color: #333;
            font-size: 0.8em;
            /* Tamaño de fuente más pequeño */
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
            background-color: #fff;
            /* Fondo blanco */
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
            /* Bordes sutiles */
            padding: 6px;
            /* Espaciado en celdas reducido */
            text-align: left;
            font-size: 0.8em;
            /* Tamaño de fuente en las celdas ajustado */
        }

        th {
            background-color: #f2f2f2;
            /* Fondo de encabezados */
            color: #333;
            font-weight: bold;
            /* Negrita */
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .company-name {
            font-weight: bold;
            /* Negrita */
            font-size: 1.2em;
            /* Tamaño de fuente del nombre de la empresa reducido */
            margin-bottom: 5px;
            /* Espacio inferior para separación */
        }

        .company-info {
            text-align: right;
            line-height: 1.5;
            /* Para mejorar la alineación vertical */
        }

        .total {
            font-weight: bold;
            text-align: right;
            font-size: 1em;
            /* Tamaño de fuente para el total ajustado */
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            color: #888;
            font-size: 0.7em;
            /* Tamaño de fuente para el pie de página más pequeño */
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        h3 {
            margin-top: 20px;
            /* Espacio superior para encabezados */
            font-weight: 700;
            /* Negrita */
            font-size: 1.2em;
            /* Tamaño de fuente para encabezados reducido */
            border-bottom: 1px solid #ccc;
            /* Línea inferior */
            padding-bottom: 5px;
            /* Espacio inferior */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="invoice-header">
            <div class="company-name">FORCE FILTERS ®</div>
            <div class="company-info">
                Email: forcefilters@gmail.com<br>
                Teléfono: 3182574787
            </div>
        </div>

        <table>
            <tr>
                <th>Fecha de compra: </th>
                <td>{{ \Carbon\Carbon::parse($sale->order_date)->format('d/m/Y') }}</td>
                <th>Hora de compra: </th>
                <td>{{ \Carbon\Carbon::parse($sale->order_date)->format('h:i A') }}</td>
            </tr>
        </table>

        <h3>Detalles del cliente:</h3>
        <table>
            <tr>
                <th>Cliente: </th>
                <td>{{ strtoupper($sale->customer->name ?? 'N/A') }}</td>
            </tr>
            <tr>
                <th>Correo Electrónico: </th>
                <td>{{ strtoupper($sale->customer->email ?? 'N/A') }}</td>
            </tr>
            <tr>
                <th>Dirección: </th>
                <td>{{ strtoupper($sale->customer->address ?? 'N/A') }}</td>
            </tr>
            <tr>
                <th>Teléfono: </th>
                <td>{{ strtoupper($sale->customer->phone ?? 'N/A') }}</td>
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
