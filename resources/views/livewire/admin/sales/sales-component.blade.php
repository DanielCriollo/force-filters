<div>
    @section('title', 'Ventas')

    @section('breadcrumb')
    <span class="text-muted fw-light">Ventas </span>
    @endsection

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Listado de ventas</h5>
                    <a href="{{ route('sales.products') }}" class="btn btn-success">Nueva Venta</a>
                </div>
                <div class="card-body">
                    <label for="">Filtro de búsqueda:</label>
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <label><small>Cliente:</small></label>
                            <input type="text" wire:model.live="customer" class="form-control" placeholder="Buscar Cliente">
                        </div>
                        <div class="col-lg-2">
                            <label><small>Desde:</small></label>
                            <input type="date" wire:model.live="startDate" class="form-control" placeholder="Desde">
                        </div>
                        <div class="col-lg-2">
                            <label><small>Hasta:</small></label>
                            <input type="date" wire:model.live="endDate" class="form-control" placeholder="Hasta">
                        </div>
                        <div class="col-lg-2">
                            <label><small>Estado:</small></label>
                            <select wire:model.live="status" class="form-control">
                                <option value="">Seleccionar</option>
                                <option value="pending">Pendiente</option>
                                <option value="completed">Completado</option>
                                <option value="cancelled">Cancelado</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <div class="mt-4">
                                <button wire:click="clearFilters" class="btn btn-primary btn-block">Limpiar Filtros</button>
                            </div>  
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Cliente</th>
                                            <th>Fecha</th>
                                            <th>Cantidad Productos</th>
                                            <th>Total Compra</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!count($sales)>0)
                                            <tr>
                                                <td colspan="7" class="text-center"><span>No se encontraron resultados</span></td>
                                            </tr>
                                        @endif
                                        @foreach ($sales as $sale)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $sale->customer->name ?? 'N/A' }}</td>
                                                <td>{{ $sale->order_date }}</td>
                                                <td>{{ $sale->items->count() }}</td>
                                                <td>{{ number_format($sale->total_amount, 2) }}</td>
                                                <td>{{ $sale->status }}</td>
                                                <td>
                                                    <button class="btn btn-info btn-sm" onclick="window.open('{{ route('sales.invoice', $sale->uuid) }}', '_blank')">Ver Factura</button>
                                                    <button  class="btn btn-danger btn-sm" 
                                                        onclick="if(confirm('¿Estás seguro de que deseas eliminar esta venta?')) { @this.deleteSale({{ $sale->id }}) }">
                                                        Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-12">
                            {{ $sales->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
