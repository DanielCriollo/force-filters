<div wire:ignore.self class="modal fade" id="edit-modal" data-bs-backdrop="static" tabindex="-1" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" wire:ignore.self>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Cliente</h5>
                <button type="button" class="btn-close" wire:click="cancel"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mt-2">
                            <label for="name">Nombre: <span class="text-danger">*</span></label></label>
                            <input type="text" class="form-control @error('name') input-error @enderror" wire:model="name">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label for="identification">Identificación:</label>
                            <input type="text" class="form-control @error('identification') input-error @enderror" wire:model="identification">
                            @error('identification')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label for="address">Dirección:</label>
                            <input type="text" class="form-control @error('address') input-error @enderror" wire:model="address">
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label for="phone">Teléfono: <span class="text-danger">*</span></label></label>
                            <input type="text" class="form-control @error('phone') input-error @enderror" wire:model="phone">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label for="email">Correo electrónico:</label>
                            <input type="email" class="form-control @error('email') input-error @enderror" wire:model="email">
                            @error('email')
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
