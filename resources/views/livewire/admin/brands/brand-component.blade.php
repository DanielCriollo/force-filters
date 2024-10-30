<div>
    @include('livewire.admin.brands.modals.show')
    @include('livewire.admin.brands.modals.create')
    @include('livewire.admin.brands.modals.edit')
    @include('livewire.admin.brands.modals.delete')

    @section('title', 'Marcas')

    @section('breadcrumb')
        <span class="text-muted fw-light">Marcas</span>
    @endsection

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Listado de marcas</h5>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#create-modal">Nueva
                        Marca</button>
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
                                            <x-table-column field="name" sortField="{{ $sortField }}"
                                                sortDirection="{{ $sortDirection }}" label="Nombre" />
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($brands as $brand)
                                            <tr>
                                                <td>{{ $brand->id }}</td>
                                                <td>{{ $brand->name }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <button class="btn btn-primary btn-sm me-1"
                                                            data-bs-toggle="modal" data-bs-target="#show-modal"
                                                            wire:click='show({{ $brand->id }})'><i
                                                                class="fas fa-eye"></i></button>
                                                        <button class="btn btn-warning btn-sm me-1"
                                                            data-bs-toggle="modal" data-bs-target="#edit-modal"
                                                            wire:click='edit({{ $brand->id }})'><i
                                                                class="fas fa-edit"></i></button>
                                                        <button class="btn btn-danger btn-sm me-1"
                                                            data-bs-toggle="modal" data-bs-target="#delete-modal"
                                                            wire:click='delete({{ $brand->id }})'><i
                                                                class="fas fa-trash"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row no-margin-bottom">
                    <div class="col-lg-6" style="padding-top:22px">
                        <span>{!! $paginationText !!}</span>
                    </div>
                    <div class="col-lg-6 text-right">
                        {{ $brands->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
