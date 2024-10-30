<div wire:ignore.self class="modal fade" id="edit-modal" data-bs-backdrop="static" tabindex="-1" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" wire:ignore.self>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Categoría de Producto</h5>
                <button type="button" class="btn-close" wire:click="cancel"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mt-2">
                            <label for="productTypeId">Tipo de producto:<span class="text-danger">*</span></label>
                            <select wire:model="productTypeId" class="form-control">
                                <option disabled value="">Seleccionar</option>
                                @foreach ($productTypes as $productType)
                                    <option value="{{ $productType->id }}">{{ $productType->name }}</option>
                                @endforeach
                            </select>
                            @error('productTypeId')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label for="name">Nombre:</label>
                            <input type="text" id="name" wire:model="name" class="form-control">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description mt-2">Descripción:</label>
                            <textarea id="description" wire:model="description" class="form-control" placeholder="Descripción"></textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
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
