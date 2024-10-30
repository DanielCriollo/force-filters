<div>
    @include('livewire.admin.products.modals-products.show')
    @include('livewire.admin.products.modals-products.create')
    @include('livewire.admin.products.modals-products.edit')
    @include('livewire.admin.products.modals-products.delete')

    <style>
        .dropdown-menu {
            z-index: 9999;
        }
    </style>
    <div class="page-content browse container-fluid">
        <div class="row no-margin-bottom">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                <button class="btn btn-success smb" data-toggle="modal"
                                    data-target="#create-modal">Crear</button>
                            </div>
                        </div>
                        <div class="row no-margin-bottom" style="margin-bottom:12px">
                            <div class="col-lg-12">
                                <label><strong>Buscar producto:</strong></label>
                                <input type="text" class="form-control" wire:model.live.debounce.250ms="searchName"
                                    placeholder="Nombre del producto">
                            </div>
                        </div>
                        <div class="row no-margin-bottom">
                            <div class="col-lg-12">
                                {{-- <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <x-table-column field="id" sortField="{{ $sortField }}"
                                                    sortDirection="{{ $sortDirection }}" label="ID" />
                                                <x-table-column field="name" sortField="{{ $sortField }}"
                                                    sortDirection="{{ $sortDirection }}" label="Nombre" />
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
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->category->productType->name }}</td>
                                                <td>{{ $product->category->name }}</td>
                                                <td>{{ $product->sku }}</td>
                                                <td>{{ number_format($product->cost_price, 2) }}</td>
                                                <td>{{ number_format($product->sale_price, 2) }}</td>
                                                <td>
                                                    <button class="btn btn-primary sm-b" data-toggle="modal"
                                                        data-target="#show-modal"
                                                        wire:click='show({{ $product->id }})'>Ver</button>
                                                    <button class="btn btn-warning sm-b" data-toggle="modal"
                                                        data-target="#edit-modal"
                                                        wire:click='edit({{ $product->id }})'>Editar</button>
                                                    <button class="btn btn-danger sm-b" data-toggle="modal"
                                                        data-target="#delete-modal"
                                                        wire:click='delete({{ $product->id }})'>Eliminar</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> --}}
                                <style>
                                    .panel-body {
                                        display: flex;
                                        flex-direction: column;
                                        gap: 10px; /* Espacio reducido entre propiedades */
                                        padding: 15px; /* Padding reducido */
                                    }
                                
                                    .property-box {
                                        background-color: #f7f7f7;
                                        padding: 8px 12px; /* Padding reducido */
                                        border-radius: 5px; /* Bordes ligeramente redondeados */
                                        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1); /* Sombra reducida */
                                        display: flex;
                                        align-items: center;
                                        width: 100%;
                                    }
                                
                                    .property-box .property-icon {
                                        font-size: 16px; /* Tamaño del icono reducido */
                                        color: #5bc0de; /* Color del icono */
                                        margin-right: 8px; /* Espacio entre icono y texto reducido */
                                    }
                                
                                    .property-text {
                                        font-weight: 500; /* Peso del texto ligeramente reducido */
                                        color: #333; /* Color del texto */
                                        font-size: 14px; /* Tamaño de texto reducido */
                                    }
                                
                                    .panel-footer {
                                        text-align: right;
                                        padding: 8px; /* Padding reducido */
                                        background-color: #f9f9f9;
                                        border-top: 1px solid #ddd;
                                        font-size: 12px; /* Tamaño de texto en pie de panel reducido */
                                    }
                                
                                    .dropdown-menu a {
                                        display: flex;
                                        align-items: center;
                                    }
                                
                                    .dropdown-menu a .glyphicon {
                                        margin-right: 5px; /* Espacio entre icono y texto */
                                    }
                                </style>
                                
                                <div class="container">
                                    <div class="row">
                                        @foreach ($products as $product)
                                        <!-- Panel para cada producto -->
                                        <div class="col-md-4">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
                                                    <h5 class="panel-title" style="flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-right: 10px;">
                                                        {{ $product->name }}
                                                    </h5>
                                                    <div class="dropdown">
                                                        <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <span class="glyphicon glyphicon-option-vertical"></span>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                            <li><a href="#" data-toggle="modal" data-target="#edit-modal" wire:click='edit({{ $product->id }})'>
                                                                <span class="glyphicon glyphicon-pencil"></span> Editar</a></li>
                                                            <li><a href="#" data-toggle="modal" data-target="#delete-modal" wire:click='delete({{ $product->id }})'>
                                                                <span class="glyphicon glyphicon-trash"></span> Eliminar</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                
                                                <div class="panel-body">
                                                    <!-- Cada propiedad está en su propia línea -->
                                                    <div class="property-box">
                                                        <span class="property-icon glyphicon glyphicon-barcode"></span>
                                                        <span class="property-text">ID: {{ $product->id }}</span>
                                                    </div>
                                
                                                    <div class="property-box">
                                                        <span class="property-icon glyphicon glyphicon-tag"></span>
                                                        <span class="property-text">Tipo: {{ $product->category->productType->name }}</span>
                                                    </div>
                                
                                                    <div class="property-box">
                                                        <span class="property-icon glyphicon glyphicon-folder-open"></span>
                                                        <span class="property-text">Categoría: {{ $product->category->name }}</span>
                                                    </div>
                                
                                                    <div class="property-box">
                                                        <span class="property-icon glyphicon glyphicon-qrcode"></span>
                                                        <span class="property-text">SKU: {{ $product->sku }}</span>
                                                    </div>
                                
                                                    <div class="property-box">
                                                        <span class="property-icon glyphicon glyphicon-usd"></span>
                                                        <span class="property-text">Costo: {{ number_format($product->cost_price, 2) }}</span>
                                                    </div>
                                
                                                    <div class="property-box">
                                                        <span class="property-icon glyphicon glyphicon-tag"></span>
                                                        <span class="property-text">Venta: {{ number_format($product->sale_price, 2) }}</span>
                                                    </div>
                                                </div>
                                
                                                <div class="panel-footer">
                                                    <small><em>Última actualización</em></small>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                
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
</div>
