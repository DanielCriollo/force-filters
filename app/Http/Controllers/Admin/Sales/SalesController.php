<?php

namespace App\Http\Controllers\Admin\Sales;

use App\SalesOrder;
use PDF;
use App\Http\Controllers\Controller;

class SalesController extends Controller
{
    public function downloadInvoice($uuid)
    {
        // Obtener la orden de venta
        $sale = SalesOrder::with('items.product')->where('uuid', $uuid)->firstOrFail();

        // Generar el PDF
        $pdf = PDF::loadView('invoices.invoice', compact('sale'));

        // Abrir el PDF en otra pestaña
        return $pdf->stream('factura_' . $sale->id . '.pdf');
    }
}
