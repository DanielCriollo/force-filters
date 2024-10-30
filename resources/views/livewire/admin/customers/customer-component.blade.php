<div>
    @include('livewire.admin.customers.modals.show')
    @include('livewire.admin.customers.modals.create')
    @include('livewire.admin.customers.modals.edit')
    @include('livewire.admin.customers.modals.delete')

    @section('title', 'Clientes')

    @section('breadcrumb')
        <span class="text-muted fw-light">Clientes</span>
    @endsection

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Listado de clientes</h5>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#create-modal">Nuevo Cliente</button>
                </div>
                <div class="card-body">
                    <label for="">Filtro de búsqueda:</label>
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <input type="text" class="form-control" wire:model.live.debounce.250ms="searchName"
                                placeholder="Nombre">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <x-table-column field="id" sortField="{{ $sortField }}"
                                                sortDirection="{{ $sortDirection }}" label="ID" />
                                            <x-table-column field="identification" sortField="{{ $sortField }}"
                                                sortDirection="{{ $sortDirection }}" label="Identificación" />
                                            <x-table-column field="name" sortField="{{ $sortField }}"
                                                sortDirection="{{ $sortDirection }}" label="Nombre" />
                                            <x-table-column field="address" sortField="{{ $sortField }}"
                                                sortDirection="{{ $sortDirection }}" label="Dirección" />
                                            <x-table-column field="phone" sortField="{{ $sortField }}"
                                                sortDirection="{{ $sortDirection }}" label="Teléfono" />
                                            <x-table-column field="email" sortField="{{ $sortField }}"
                                                sortDirection="{{ $sortDirection }}" label="Correo electrónico" />
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!count($customers)>0)
                                            <tr>
                                                <td colspan="7" class="text-center"><span>No se encontraron resultados</span></td>
                                            </tr>
                                        @endif
                                        @foreach ($customers as $customer)
                                            <tr>
                                                <td>{{ $customer->id }}</td>
                                                <td>{{ $customer->identification }}</td>
                                                <td>{{ $customer->name }}</td>
                                                <td>{{ $customer->address }}</td>
                                                <td>{{ $customer->phone }}</td>
                                                <td>{{ $customer->email }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <button class="btn btn-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#show-modal"
                                                            wire:click='show({{ $customer->id }})' title="Ver">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#edit-modal"
                                                            wire:click='edit({{ $customer->id }})' title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-modal"
                                                            wire:click='delete({{ $customer->id }})' title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-6" style="padding-top:22px">
                            <span>{!! $paginationText !!}</span>
                        </div>
                        <div class="col-lg-6 text-right">
                            {{ $customers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
