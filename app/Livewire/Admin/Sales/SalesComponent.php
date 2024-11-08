<?php

namespace App\Livewire\Admin\Sales;

use App\SalesOrder;
use Livewire\Component;
use Livewire\WithPagination;

class SalesComponent extends Component
{
    use WithPagination;

    public $customer, $startDate, $endDate, $payment_mode;

    public function render()
    {
        $query = SalesOrder::query();

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

        if ($this->payment_mode) {
            $query->where('payment_mode', $this->payment_mode);
        }

        $sales = $query->paginate(12);

        return view('livewire.admin.sales.sales-component', [
            'sales' => $sales
        ]);
    }

    public function clearFilters()
    {
        $this->customer = '';
        $this->startDate = null;
        $this->endDate = null;
        $this->status = '';
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
}
