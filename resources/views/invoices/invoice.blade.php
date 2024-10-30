<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura #{{ $sale->id }}</title>
    <style>
        /* Estilos básicos para la factura */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff; /* Fondo blanco */
            color: #333;
            font-size: 0.7em; /* Tamaño de fuente más pequeño */
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
            background-color: #fff; /* Fondo blanco */
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
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
            font-weight: bold; /* Negrita */
            font-size: 1.5em; /* Tamaño de fuente del nombre de la empresa */
            margin-bottom: 5px; /* Espacio inferior para separación */
        }
        .company-info {
            text-align: right;
            line-height: 1.5; /* Para mejorar la alineación vertical */
        }
        .total {
            font-weight: bold;
            text-align: right;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
            color: #888;
            font-size: 0.6em; /* Tamaño de fuente más pequeño */
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
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
                <th>Fecha de compra</th>
                <td>{{ $sale->order_date }}</td>
            </tr>
        </table>

        <h3>Detalles del cliente:</h3>
        <table>
            <tr>
                <th>Cliente: </th>
                <td>{{ $sale->customer->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Correo electrónico: </th>
                <td>{{ $sale->customer->email ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Dirección: </th>
                <td>{{ $sale->customer->address ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Teléfono: </th>
                <td>{{ $sale->customer->phone ?? 'N/A' }}</td>
            </tr>
        </table>

        <h3>Detalles de la compra:</h3>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Precio Unitario</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-right">{{ number_format($item->total_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="total">Total: {{ number_format($sale->total_amount, 2) }}</div>
    </div>

    <div class="footer">
        &copy; <span id="currentYear"></span> FORCE FILTERS. Todos los derechos reservados.
    </div>

    <script>
        // Script para obtener el año actual
        document.getElementById('currentYear').innerText = new Date().getFullYear();
    </script>
</body>
</html>
