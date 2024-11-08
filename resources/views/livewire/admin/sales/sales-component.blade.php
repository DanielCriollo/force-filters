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
                    <a href="{{ route('sales-products') }}" class="btn btn-success">Nueva Venta</a>
                </div>
                <div class="card-body">
                    <label for="">Filtro de búsqueda:</label>
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <label><small>Cliente:</small></label>
                            <input type="text" wire:model.live="customer" class="form-control"
                                placeholder="Buscar Cliente">
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
                            <label><small>Forma de pago:</small></label>
                            <select wire:model.live="paymentMode" class="form-control">
                                <option value="">Seleccionar</option>
                                <option value="credit">Crédito</option>
                                <option value="cash">Contado</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <div class="mt-4">
                                <button wire:click="clearFilters" class="btn btn-primary">Limpiar
                                    Filtros</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Cliente</th>
                                            <th class="text-center">Fecha</th>
                                            <th class="text-center">Cantidad Productos</th>
                                            <th class="text-center">Total Compra</th>
                                            <th class="text-center">Forma de pago</th>
                                            <th class="text-center">Fecha Vencimiento</th>
                                            <th class="text-center">Días Restantes</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!count($sales) > 0)
                                            <tr>
                                                <td colspan="7" class="text-center"><span>No se encontraron
                                                        resultados</span></td>
                                            </tr>
                                        @endif
                                        @foreach ($sales as $sale)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $sale->customer->name ?? 'N/A' }}</td>
                                                <td>{{ $sale->order_date }}</td>
                                                <td class="text-center">{{ $sale->items->count() }}</td>
                                                <td>{{ number_format($sale->total_amount, 2) }}</td>
                                                <td class="text-center">
                                                    @if ($sale->payment_mode === 'cash')
                                                        <span class="badge bg-success">Contado</span>
                                                    @elseif($sale->payment_mode === 'credit')
                                                        <span class="badge bg-primary">Crédito</span>
                                                    @else
                                                        <span class="badge bg-secondary">N/A</span>
                                                    @endif
                                                </td>
                                                <td>{{ $sale->due_date ?? '-' }}</td>
                                                <td class="text-center">
                                                    @php
                                                        $dueDate = $sale->due_date
                                                            ? Carbon\Carbon::parse($sale->due_date)
                                                            : null;
                                                        $daysRemaining = $dueDate
                                                            ? now()->diffInDays($dueDate, false)
                                                            : null;
                                                    @endphp

                                                    @if ($daysRemaining !== null)
                                                        @if ($daysRemaining < 0)
                                                            <span class="text-danger"><small>Vencida ({{ abs($daysRemaining) }}
                                                                días)</small></span>
                                                        @elseif($daysRemaining === 0)
                                                            <span class="text-warning"><small>Vence hoy</small></span>
                                                        @else
                                                            <span class="text-success"><small>Faltan {{ $daysRemaining }}
                                                                días</small></span>
                                                        @endif
                                                    @else
                                                        {{ '-' }}
                                                    @endif
                                                </td>

                                                <td>
                                                    <a class="btn btn-info btn-sm" title="Ver PDF de la Factura"
                                                        href="{{ route('sales.invoice', $sale->uuid) }}"
                                                        target="_blank">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </a>

                                                    <a class="btn btn-warning btn-sm" title="Editar Venta"
                                                        href="{{ route('sales-products.update', $sale->id) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-danger btn-sm" title="Eliminar Venta"
                                                        onclick="if(confirm('¿Estás seguro de que deseas eliminar esta venta?')) { @this.deleteSale({{ $sale->id }}) }">
                                                        <i class="fas fa-trash-alt"></i>
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
