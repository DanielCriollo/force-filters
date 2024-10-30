<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="edit-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="Close" wire:click="cancel()">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">
                    <i class="fa fa-tag"></i>&nbsp;Editar producto
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="name">Nombre: <span class="text-danger">*</span></label>
                            <input type="text" id="name" class="form-control @error('name') input-error @enderror" wire:model="name" placeholder="Nombre del producto">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="productType">Tipo de Producto: <span class="text-danger">*</span></label>
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
                        <div class="form-group">
                            <label for="productCategory">Categoría: <span class="text-danger">*</span></label>
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
                        <div class="form-group">
                            <label for="brand">Marca:</label>
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
                        <div class="form-group">
                            <label for="sku">SKU:</label>
                            <input type="text" id="sku" class="form-control @error('sku') input-error @enderror" wire:model="sku" placeholder="Código SKU">
                            @error('sku')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="costPrice">Precio de Costo: <span class="text-danger">*</span></label>
                            <input type="number" id="costPrice" step="0.01" class="form-control @error('costPrice') input-error @enderror" wire:model="costPrice" placeholder="Precio de Costo">
                            @error('costPrice')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="salePrice">Precio de Venta: <span class="text-danger">*</span></label>
                            <input type="number" id="salePrice" step="0.01" class="form-control @error('salePrice') input-error @enderror" wire:model="salePrice" placeholder="Precio de Venta">
                            @error('salePrice')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="stockQuantity">Cantidad en Stock: <span class="text-danger">*</span></label>
                            <input type="number" id="stockQuantity" class="form-control @error('stockQuantity') input-error @enderror" wire:model="stockQuantity" placeholder="Cantidad en Stock">
                            @error('stockQuantity')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="minStockQuantity">Cantidad Mínima en Stock:</label>
                            <input type="number" id="minStockQuantity" class="form-control @error('minStockQuantity') input-error @enderror" wire:model="minStockQuantity" placeholder="Cantidad Mínima">
                            @error('minStockQuantity')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="reorderQuantity">Cantidad de Reorden:</label>
                            <input type="number" id="reorderQuantity" class="form-control @error('reorderQuantity') input-error @enderror" wire:model="reorderQuantity" placeholder="Cantidad de Reorden">
                            @error('reorderQuantity')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary pull-right" wire:click="update()">
                    <i class="fa fa-floppy-o"></i>&nbsp;Guardar
                </button>
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()">
                    <i class="fa fa-ban"></i>&nbsp;Cancelar
                </button>
            </div>
        </div>
    </div>
</div>
