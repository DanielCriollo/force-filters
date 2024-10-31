<div wire:ignore.self class="modal fade" id="edit-modal" data-bs-backdrop="static" tabindex="-1" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" wire:ignore.self>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Producto</h5>
                <button type="button" class="btn-close" wire:click="cancel"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mt-2">
                            <label for="name">Nombre: <span class="text-danger">*</span></label>
                            <input type="text" id="name" class="form-control @error('name') input-error @enderror" wire:model="name" placeholder="Nombre del producto">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label>Descripción: <span class="text-danger">*</span></label>
                            <textarea  class="form-control" wire:model.live='description'></textarea>
                            @error('description')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label>Tipo de Producto: <span class="text-danger">*</span></label>
                            <select class="form-control @error('productType') input-error @enderror" wire:model.live="productType">
                                <option disabled value="">Seleccione un tipo</option>
                                @foreach ($productTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('productType')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label>Categoría: <span class="text-danger">*</span></label>
                            <select class="form-control @error('productCategory') input-error @enderror" wire:model.change="productCategory">
                                <option disabled value="">Seleccione una categoría</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('productCategory')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>                     
                        <div class="form-group mt-2">
                            <label>Marca:</label>
                            <select id="brand" class="form-control @error('brand') input-error @enderror" wire:model="brand">
                                <option disabled value="">Seleccione una marca</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brand')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label>SKU:</label>
                            <input type="text" id="sku" class="form-control @error('sku') input-error @enderror" wire:model="sku" placeholder="Código SKU">
                            @error('sku')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label>Precio de Costo: <span class="text-danger">*</span></label>
                            <input type="number" id="costPrice" step="0.01" class="form-control @error('costPrice') input-error @enderror" wire:model="costPrice" placeholder="Precio de Costo">
                            @error('costPrice')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label>Precio de Venta: <span class="text-danger">*</span></label>
                            <input type="number" id="salePrice" step="0.01" class="form-control @error('salePrice') input-error @enderror" wire:model="salePrice" placeholder="Precio de Venta">
                            @error('salePrice')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label>Cantidad en Stock: <span class="text-danger">*</span></label>
                            <input type="number" id="stockQuantity" class="form-control @error('stockQuantity') input-error @enderror" wire:model="stockQuantity" placeholder="Cantidad en Stock">
                            @error('stockQuantity')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label>Cantidad Mínima en Stock:</label>
                            <input type="number" id="minStockQuantity" class="form-control @error('minStockQuantity') input-error @enderror" wire:model="minStockQuantity" placeholder="Cantidad Mínima">
                            @error('minStockQuantity')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label>Cantidad de Reorden:</label>
                            <input type="number" id="reorderQuantity" class="form-control @error('reorderQuantity') input-error @enderror" wire:model="reorderQuantity" placeholder="Cantidad de Reorden">
                            @error('reorderQuantity')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label>Imagen:</label>
                            <input type="file" class="form-control @error('mainPhoto') input-error @enderror" wire:model="mainPhoto" accept="image/*">
                            @error('mainPhoto')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" wire:click="cancel">
                    Cancelar
                </button>
                <button type="button" class="btn btn-primary" wire:click="update()">Guardar</button>
            </div>
        </div>
    </div>
</div>
