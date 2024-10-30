<div wire:ignore.self class="modal fade" id="show-modal" data-bs-backdrop="static" tabindex="-1" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" wire:ignore.self>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles del cliente</h5>
                <button type="button" class="btn-close" wire:click="cancel"></button>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <p><strong>Nombre:</strong> {{ $name }}</p>
                        <p><strong>Identificación:</strong> {{ $identification }}</p>
                        <p><strong>Dirección:</strong> {{ $address }}</p>
                        <p><strong>Teléfono:</strong> {{ $phone }}</p>
                        <p><strong>Correo electrónico:</strong> {{ $email }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" wire:click="cancel">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>
