<?php

namespace App\Http\Controllers\Admin\Sales;

use App\SalesOrder;
use PDF;
use App\Http\Controllers\Controller;

class SalesController extends Controller
{
    public function downloadInvoice($id)
    {
        // Obtener la orden de venta
        $sale = SalesOrder::with('items.product')->findOrFail($id);

        // Generar el PDF
        $pdf = PDF::loadView('invoices.invoice', compact('sale'));

        // Abrir el PDF en otra pestaña
        return $pdf->stream('factura_' . $sale->id . '.pdf');
    }
}
