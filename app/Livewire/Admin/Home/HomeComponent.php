<?php

namespace App\Livewire\Admin\Home;

use Carbon\Carbon;
use App\SalesOrder;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class HomeComponent extends Component
{

    public $salesData = [];

    public $totalVendido;
    public $totalVendidoUltimoMes;

    public function mount()
    {
        $this->calcularTotalVendido();
        $this->calcularTotalVendidoUltimoMes();
        
        $currentYear = Carbon::now()->year;
        
        $allMonths = [];
        for ($month = 1; $month <= 12; $month++) {
            $allMonths[$month] = Carbon::createFromFormat('m', $month)->format('F');
        }
    
        $monthlySales = SalesOrder::select(
                DB::raw("SUM(total_amount) as total"),
                DB::raw("COUNT(id) as quantity"),
                DB::raw("MONTH(updated_at) as month")
            )
            ->whereYear('updated_at', $currentYear)
            ->groupBy(DB::raw("MONTH(updated_at)"))
            ->orderBy(DB::raw("MONTH(updated_at)"))
            ->get();
    
        $salesByMonth = [];
        $quantityByMonth = [];
        foreach ($monthlySales as $sale) {
            $salesByMonth[$sale->month] = round($sale->total);
            $quantityByMonth[$sale->month] = $sale->quantity; 
        }
    
        foreach ($allMonths as $monthNumber => $monthName) {
            $this->salesData['labels'][] = $monthName;
            $this->salesData['data'][] = $salesByMonth[$monthNumber] ?? 0;
            $this->salesData['quantity'][] = $quantityByMonth[$monthNumber] ?? 0;
        }
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
        $this->totalVendidoUltimoMes = SalesOrder::whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->sum('total_amount');
    }
}
