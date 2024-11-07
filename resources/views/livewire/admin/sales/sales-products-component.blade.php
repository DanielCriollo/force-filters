<div>

    @include('livewire.admin.sales.modals-items.create')

    @section('title', 'Nueva Venta')

    @section('breadcrumb')
        <span class="text-muted fw-light">
            <a href="{{ route('sales') }}" class="text-muted text-decoration-none">Ventas</a> /
        </span> 
        Nueva Venta
    @endsection


    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Información general</h5>
                </div>
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-lg-3">
                            <label>Fecha</label>
                            <input type="datetime-local" class="form-control" wire:model.live='orderDate'>
                        </div>                        
                        <div class="col-lg-3">
                            <label>Modo de pago: </label>
                            <select  class="form-control" wire:model.live='paymentMode'>
                                <option value="">Seleccionar</option>
                                <option value="credit">Crédito</option>
                                <option value="cash">Contado</option>
                            </select>
                        </div>
                        @if($paymentMode == 'credit')
                            <div class="col-lg-3">
                                <label>Plazo (días):</label>
                                <input type="number" class="form-control" min="1" wire:model.live="paymentTerm">
                            </div>

                            <div class="col-lg-3">
                                <label>Fecha de pago:</label>
                                <input type="date" class="form-control" wire:model.live="dueDate" readonly>
                            </div>
                        @endif
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <label>Buscar Cliente</label>
                            <input type="text" class="form-control" wire:model="searchCustomer" wire:keyup="searchName"
                                placeholder="Nombre del cliente">
                            @if(!empty($matchingCustomers))
                                <ul class="list-group mt-2">
                                    @foreach($matchingCustomers as $customer)
                                        <li class="list-group-item list-group-item-action" style="cursor: pointer;"
                                            wire:click="selectCustomer({{ $customer->id }})">
                                            {{ $customer->identification }} - {{ $customer->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            @if($noResults)
                                <div class="mt-2 text-danger">No se encontraron resultados</div>
                                <div class="card mb-3 mt-3">
                                    <div class="card-header mb-0">
                                        <h6 class="mb-0">Crear Nuevo Cliente</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mt-2">
                                            <div class="col-lg-12">
                                                <div class="form-group mt-2">
                                                    <label for="identification">Identificación: <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" wire:model="identification" placeholder="Identificación">
                                                    @error('identification') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label for="name">Nombre: <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" wire:model="name" placeholder="Nombre">
                                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label for="email">Correo Electrónico: <span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" wire:model="email" placeholder="Correo Electrónico">
                                                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label for="phone">Teléfono: <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" wire:model="phone" placeholder="Teléfono">
                                                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label for="address">Dirección: <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" wire:model="address" placeholder="Dirección">
                                                    @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12 text-center">
                                                <button class="btn btn-success mt-3" wire:click="createCustomer">Crear Cliente</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @if ($customerId)
                        <div class="row mt-2">
                            <div class="col-lg-4">
                                <label for="">Identificación:</label>
                                <input type="text" class="form-control" wire:model='identification' disabled>
                            </div>
                            <div class="col-lg-4">
                                <label for="">Nombre:</label>
                                <input type="text" class="form-control" wire:model='name' disabled>
                            </div>
                            <div class="col-lg-4">
                                <label for="">Correo electrónico:</label>
                                <input type="text" class="form-control" wire:model='email' disabled>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-8">
                                <label for="">Dirección:</label>
                                <input type="text" class="form-control" wire:model='address' disabled>
                            </div>
                            <div class="col-lg-4">
                                <label for="">Teléfono:</label>
                                <input type="text" class="form-control" wire:model='phone' disabled>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @if ($customerId)
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Información productos</h5>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#create-modal">Agregar Producto</button>
                    </div>
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>Precio Unitario</th>
                                                <th>Subtotal</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @error('productsCart')
                                            <tr>
                                                <th colspan="6" class="text-center">
                                                    <span class="text-danger">{{ $message }}</span>
                                                </th>
                                            </tr>
                                            @enderror   
                                            @foreach ($productsCart as $key => $item)
                                            <tr>
                                                <td>{{ $item['id'] }}</td>
                                                <td>{{ $item['name'] }}</td>
                                                <td>{{ number_format($item['quantity']) }}</td>
                                                <td>{{ number_format($item['unitPrice'], 2, '.', ',') }}</td>
                                                <td>{{ number_format($item['subtotal'], 2, '.', ',') }}</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm" title="Actualizar">
                                                        <i class="fas fa-sync"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm" title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2">Totales</th>
                                                <th>{{ number_format(array_sum(array_column($productsCart, 'quantity'))) }}</th>
                                                <th>{{ number_format(array_sum(array_column($productsCart, 'unitPrice')), 2, '.', ',') }}</th>
                                                <th>{{ number_format(array_sum(array_column($productsCart, 'subtotal')), 2, '.', ',') }}</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>                                                                                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-lg-12 text-center">
                                @if ($saleOrderId)
                                <button class="btn btn-success" wire:click='store()'>Actualizar Compra</button>
                                @else
                                <button class="btn btn-success" wire:click='store()'>Finalizar Compra</button>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
