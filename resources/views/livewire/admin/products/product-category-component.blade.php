<div>
    @include('livewire.admin.products.modals-categories.show')
    @include('livewire.admin.products.modals-categories.create')
    @include('livewire.admin.products.modals-categories.edit')
    @include('livewire.admin.products.modals-categories.delete')

    @section('title', 'Categorías de productos')

    @section('breadcrumb')
        <span class="text-muted fw-light">Categorías de productos</span>
    @endsection

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Listado Categorías de Productos</h5>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#create-modal">Nueva Categoría</button>
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
                                            <x-table-column field="id" sortField="{{ $sortField }}" sortDirection="{{ $sortDirection }}" label="ID" />
                                            <x-table-column field="product_type_id" sortField="{{ $sortField }}" sortDirection="{{ $sortDirection }}" label="Tipo de Producto" />
                                            <x-table-column field="name" sortField="{{ $sortField }}" sortDirection="{{ $sortDirection }}" label="Nombre" />
                                            <x-table-column field="description" sortField="{{ $sortField }}" sortDirection="{{ $sortDirection }}" label="Descripción" />
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productCategories as $productCategory)
                                            <tr>
                                                <td>{{ $productCategory->id }}</td>
                                                <td>{{ $productCategory->productType->name }}</td>
                                                <td>{{ $productCategory->name }}</td>
                                                <td>{{ $productCategory->description }}</td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#show-modal" wire:click='show({{ $productCategory->id }})'>
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit-modal" wire:click='edit({{ $productCategory->id }})'>
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-modal" wire:click='delete({{ $productCategory->id }})'>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-lg-6" style="padding-top:22px">
                                <span>{!! $paginationText !!}</span>
                            </div>
                            <div class="col-lg-6 text-right">
                                {{ $productCategories->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
