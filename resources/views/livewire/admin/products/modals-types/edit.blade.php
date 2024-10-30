<div wire:ignore.self class="modal fade" id="edit-modal" data-bs-backdrop="static" tabindex="-1" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" wire:ignore.self>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Tipo de Prodcto</h5>
                <button type="button" class="btn-close" wire:click="cancel"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mt-2">
                            <label for="name">Nombre: <span class="text-danger">*</span></label>
                            <input type="text" id="name" class="form-control @error('name') input-error @enderror" wire:model="name" placeholder="Nombre del tipo de producto">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label for="description">Descripción:</label>
                            <input type="text" id="description" class="form-control @error('description') input-error @enderror" wire:model="description" placeholder="Descripción del tipo de producto">
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
                <button type="button" class="btn btn-primary" wire:click="update()">Guardar</button>
            </div>
        </div>
    </div>
</div>
