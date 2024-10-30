<div wire:ignore.self class="modal fade" id="create-modal" data-bs-backdrop="static" tabindex="-1" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" wire:ignore.self>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Añadir Producto</h5>
                <button type="button" class="btn-close" wire:click="cancel"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <label>Buscar Producto: </label>
                        <input type="text" class="form-control" wire:model="searchProduct" wire:keyup="searchProductName"
                            placeholder="Nombre del producto">
                        @if(!empty($matchingProducts))
                            <ul class="list-group mt-2">
                                @foreach($matchingProducts as $product)
                                    <li class="list-group-item list-group-item-action" style="cursor: pointer;"
                                        wire:click="selectProduct({{ $product->id }})">
                                        {{ $product->name }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        @if($noResultsProducts == true)
                            <div class="mt-2 text-danger">No se encontraron resultados</div>
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <label>Nombre:</label>
                                    <input type="text" class="form-control" wire:model='nameProduct'>
                                    @error('nameProduct') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <label for="">Descripción:</label>
                                    <input type="text" class="form-control" wire:model='descriptionProduct'>
                                    @error('descriptionProduct') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <label for="">SKU:</label>
                                    <input type="text" class="form-control" wire:model='sku'>
                                    @error('sku') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <label for="">Tipo:</label>
                                    <input type="text" class="form-control" wire:model='type'>
                                    @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <label for="">Categoría:</label>
                                    <input type="text" class="form-control" wire:model='category'>
                                    @error('category') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <label for="">Marca:</label>
                                    <select class="form-control">
                                        <option value="">Seleccionar</option>
                                        @foreach ($brands as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('brand') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-lg-12 mt-2">
                                    <label for="">Cantidad:</label>
                                    <input type="text" class="form-control" wire:model='quantity'>
                                    @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <button class="btn btn-success" wire:click="createNewProduct">Crear Producto</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Formulario de detalles de producto seleccionado -->
                @if($productId)
                    <div class="row">
                        <div class="col-lg-12 mt-2">
                            <label for="">Nombre:</label>
                            <input type="text" class="form-control" wire:model='nameProduct' disabled>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <label for="">Descripción:</label>
                            <input type="text" class="form-control" wire:model='descriptionProduct' disabled>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <label for="">SKU:</label>
                            <input type="text" class="form-control" wire:model='sku' disabled>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <label for="">Tipo:</label>
                            <input type="text" class="form-control" wire:model='type' disabled>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <label for="">Categoría:</label>
                            <input type="text" class="form-control" wire:model='category' disabled>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <label for="">Marca:</label>
                            <input type="text" class="form-control" wire:model='brand' disabled>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <label for="">Cantidad:</label>
                            <input type="text" class="form-control" wire:model='quantity'>
                            @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" wire:click="cancel">
                    Cerrar
                </button>
                <button type="button" class="btn btn-primary" wire:click="addProduct">Añadir</button>
            </div>
        </div>
    </div>
</div>
