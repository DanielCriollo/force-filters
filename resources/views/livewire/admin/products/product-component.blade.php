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
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <h5 class="mb-2 mb-md-0">Listado de Productos</h5>
                    <button class="btn btn-success mb-2 mb-md-0" data-bs-toggle="modal" data-bs-target="#create-modal">Nuevo Producto</button>
                    <button class="btn btn-secondary" wire:click="toggleViewMode">
                        Cambiar a {{ $viewMode === 'table' ? 'Vista de Cards' : 'Vista de Tabla' }}
                    </button>
                </div>                
                <div class="card-body">
                    <label for="">Filtro de búsqueda:</label>
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <input type="text" class="form-control" wire:model.live.debounce.250ms="searchName" placeholder="Nombre">
                        </div>
                    </div>

                    <!-- Vista en tabla -->
                    @if($viewMode === 'table')
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <x-table-column field="id" sortField="{{ $sortField }}" sortDirection="{{ $sortDirection }}" label="ID" />
                                        <th>Imagen</th>
                                        <x-table-column field="name" sortField="{{ $sortField }}" sortDirection="{{ $sortDirection }}" label="Nombre" />
                                        <x-table-column field="description" sortField="{{ $sortField }}" sortDirection="{{ $sortDirection }}" label="Descripción" />
                                        <x-table-column field="productType" sortField="{{ $sortField }}" sortDirection="{{ $sortDirection }}" label="Tipo" />
                                        <x-table-column field="productCategory" sortField="{{ $sortField }}" sortDirection="{{ $sortDirection }}" label="Categoría" />
                                        <x-table-column field="brandName" sortField="{{ $sortField }}" sortDirection="{{ $sortDirection }}" label="Marca" />
                                        <x-table-column field="sku" sortField="{{ $sortField }}" sortDirection="{{ $sortDirection }}" label="SKU" />
                                        <x-table-column field="cost_price" sortField="{{ $sortField }}" sortDirection="{{ $sortDirection }}" label="Precio de Costo" />
                                        <x-table-column field="sale_price" sortField="{{ $sortField }}" sortDirection="{{ $sortDirection }}" label="Precio de Venta" />
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if($product->main_photo)
                                                <img src="{{ asset('storage/' . $product->main_photo) }}" alt="{{ $product->name }}" style="width: 50px; height: auto;" onclick="openImageModal('{{ asset('storage/' . $product->main_photo) }}')" />
                                            @else
                                                Sin imagen
                                            @endif
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td>{{ $product->category->productType->name }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>{{ $product->brand->name }}</td>
                                        <td>{{ $product->sku }}</td>
                                        <td>{{ number_format($product->cost_price, 2) }}</td>
                                        <td>{{ number_format($product->sale_price, 2) }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#show-modal" wire:click='show({{ $product->id }})'>
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit-modal" wire:click='edit({{ $product->id }})'>
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-modal" wire:click='delete({{ $product->id }})'>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    <!-- Vista en cards -->
                    @else
                        <div class="row">
                            @foreach ($products as $product)
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <img src="{{ $product->main_photo ? asset('storage/' . $product->main_photo) : 'sin-imagen.png' }}" class="card-img-top" alt="{{ $product->name }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text"><strong>Descripción:</strong> {{ $product->description }}</p>
                                            <p class="card-text"><strong>Tipo:</strong> {{ $product->category->productType->name }}</p>
                                            <p class="card-text"><strong>Categoría:</strong> {{ $product->category->name }}</p>
                                            <p class="card-text"><strong>Marca:</strong> {{ $product->brand->name }}</p>
                                            <p class="card-text"><strong>SKU:</strong> {{ $product->sku }}</p>
                                            <p class="card-text"><strong>Precio de Costo:</strong> ${{ number_format($product->cost_price, 2) }}</p>
                                            <p class="card-text"><strong>Precio de Venta:</strong> ${{ number_format($product->sale_price, 2) }}</p>
                                            <div class="d-flex justify-content-between">
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#show-modal" wire:click='show({{ $product->id }})'>Ver</button>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit-modal" wire:click='edit({{ $product->id }})'>Editar</button>
                                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-modal" wire:click='delete({{ $product->id }})'>Eliminar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Paginación -->
                    <div class="row">
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

    <script>
        function openImageModal(imageSrc) {
            document.getElementById('modal-image').src = imageSrc;
            $('#image-modal').modal('
