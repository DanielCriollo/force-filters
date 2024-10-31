<div wire:ignore.self class="modal fade" id="create-modal" data-bs-backdrop="static" tabindex="-1" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" wire:ignore.self>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva categoría de producto</h5>
                <button type="button" class="btn-close" wire:click="cancel"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mt-2">
                            <label for="name">Tipo de producto: <span class="text-danger">*</span></label>
                            <select class="form-control @error('productTypeId') input-error @enderror"
                                wire:model="productTypeId" placeholder="Tipo de producto">
                                <option  value="">Seleccionar</option>
                                @foreach ($productTypes as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('productTypeId')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label for="name">Nombre: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') input-error @enderror"
                                wire:model="name" placeholder="Nombre">
                            @error('name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label for="description">Descripción: </label>
                            <textarea wire:model="description" class="form-control" placeholder="Descripción"></textarea>
                            @error('description')
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
                <button type="button" class="btn btn-primary" wire:click="store()">Guardar</button>
            </div>
        </div>
    </div>
</div>
