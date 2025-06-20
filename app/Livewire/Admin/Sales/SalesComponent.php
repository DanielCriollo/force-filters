<?php

namespace App\Livewire\Admin\Sales;

use App\SalesOrder;
use Livewire\Component;
use Livewire\WithPagination;

class SalesComponent extends Component
{
    use WithPagination;

    public $customer, $startDate, $endDate, $paymentMode;
    public $status = 'pending';

    public $saleToMarkAsPaid = null;
    public $creditPaidAt = null;


    public function mount($status = null)
    {
        $this->status = $status ?? $this->status;
    }

    public function render()
    {
        $query = SalesOrder::query();

        //$query->where('status', '=', $this->status);

        // Filtro adicional según status
        if ($this->status === 'completed') {
            $query->where('payment_mode', '!=', 'credit');
        } elseif ($this->status === 'pending') {
            $query->where('payment_mode', 'credit');
        }

        if ($this->customer) {
            $query->whereHas('customer', function ($q) {
                $q->where('name', 'like', '%' . $this->customer . '%');
            });
        }

        if ($this->startDate) {
            $query->where('order_date', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->where('order_date', '<=', $this->endDate);
        }

        if ($this->paymentMode) {
            $query->where('payment_mode', $this->paymentMode);
        }

        $sales = $query->orderBy('order_date', 'desc')->paginate(12);

        return view('livewire.admin.sales.sales-component', [
            'sales' => $sales
        ]);
    }

    public function clearFilters()
    {
        $this->customer = '';
        $this->startDate = null;
        $this->endDate = null;
        $this->paymentMode = '';
    }

    public function deleteSale($id)
    {
        $sale = SalesOrder::find($id);

        if ($sale) {
            $sale->items()->delete();
            $sale->delete();
            $this->dispatch('toast', message: 'Venta eliminada exitosamente.', notify: 'success');
        } else {
            $this->dispatch('toast', message: 'No se pudo encontrar la venta.', notify: 'error');
        }
    }

    public function openMarkAsPaidModal($saleId)
    {
        $this->saleToMarkAsPaid = $saleId;
        $this->creditPaidAt = now()->format('Y-m-d\TH:i');
    }

    public function cancelMarkAsPaid()
    {
        $this->saleToMarkAsPaid = null;
        $this->creditPaidAt = null;
        $this->dispatch('close-modal');
    }

    public function markAsPaid()
    {
        $sale = \App\SalesOrder::find($this->saleToMarkAsPaid);
        if ($sale && $sale->payment_mode === 'credit' && !$sale->credit_paid_at) {
            $sale->credit_paid_at = now();
            $sale->save();

            $this->dispatch('toast', message: 'Venta marcada como pagada.', notify: 'success');
            $this->cancel();
        } else {
            $this->dispatch('toast', message: 'No se pudo marcar como pagada.', notify: 'error');
            $this->cancel();
        }
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->dispatch('close-modal');
    }

    public function resetInputFields()
    {
        $this->reset([
            'creditPaidAt',
        ]);
    }
}
