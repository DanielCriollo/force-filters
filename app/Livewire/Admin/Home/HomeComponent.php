<?php

namespace App\Livewire\Admin\Home;

use App\SalesOrder;
use Livewire\Component;

class HomeComponent extends Component
{

    public $totalVendido;
    public $totalVendidoUltimoMes;


    public function mount()
    {
        $this->calcularTotalVendido();
        $this->calcularTotalVendidoUltimoMes();
    }

    public function render()
    {
        return view('livewire.admin.home.home-component');
    }


    public function calcularTotalVendido()
    {
        $this->totalVendido = SalesOrder::sum('total_amount');
    }

    public function calcularTotalVendidoUltimoMes()
    {
        $this->totalVendidoUltimoMes = SalesOrder::where('updated_at', '>=', now()->subDays(30))
            ->sum('total_amount');
    }
}
