<div>
    @include('livewire.admin.products.modals-products.view')
    @include('livewire.admin.products.modals-products.show')
    @include('livewire.admin.products.modals-products.create')
    @include('livewire.admin.products.modals-products.edit')
    @include('livewire.admin.products.modals-products.delete')

    @section('title', 'Productos')

    @section('breadcrumb')
        <span class="text-muted fw-light">Productos</span>
    @endsection

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Listado de Productos</h5>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#create-modal">Nuevo Producto</button>
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
                                            <th>Imagen</th>
                                            <x-table-column field="name" sortField="{{ $sortField }}"
                                                sortDirection="{{ $sortDirection }}" label="Nombre" />
                                            <x-table-column field="description" sortField="{{ $sortField }}"
                                                sortDirection="{{ $sortDirection }}" label="Descripción" />    
                                            <x-table-column field="productType" sortField="{{ $sortField }}"
                                                sortDirection="{{ $sortDirection }}" label="Tipo" />
                                            <x-table-column field="productCategory" sortField="{{ $sortField }}"
                                                sortDirection="{{ $sortDirection }}" label="Categoría" />
                                            <x-table-column field="sku" sortField="{{ $sortField }}"
                                                sortDirection="{{ $sortDirection }}" label="SKU" />
                                            <x-table-column field="cost_price" sortField="{{ $sortField }}"
                                                sortDirection="{{ $sortDirection }}" label="Precio de Costo" />
                                            <x-table-column field="sale_price" sortField="{{ $sortField }}"
                                                sortDirection="{{ $sortDirection }}" label="Precio de Venta" />
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($product->main_photo)
                                                    <img src="{{ asset('storage/' . $product->main_photo) }}" alt="{{ $product->name }}"
                                                        style="width: 50px; height: auto;"
                                                        onclick="openImageModal('{{ asset('storage/' . $product->main_photo) }}')" />
                                                @else
                                                    Sin imagen
                                                @endif
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->description }}</td>
                                            <td>{{ $product->category->productType->name }}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>{{ $product->sku }}</td>
                                            <td>{{ number_format($product->cost_price, 2) }}</td>
                                            <td>{{ number_format($product->sale_price, 2) }}</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#show-modal"
                                                    wire:click='show({{ $product->id }})'>
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#edit-modal"
                                                    wire:click='edit({{ $product->id }})'>
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#delete-modal"
                                                    wire:click='delete({{ $product->id }})'>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-lg-6" style="padding-top:22px">
                                <span>{!! $paginationText !!}</span>
                            </div>
                            <div class="col-lg-6 text-right">
                                {{ $products->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openImageModal(imageSrc) {
            document.getElementById('modal-image').src = imageSrc;
            $('#image-modal').modal('show');
        }
    </script>
</div>
