<div wire:ignore.self class="modal modal-info fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="show-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" aria-label="Close" wire:click="cancel()">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">
                    <i class="fa fa-info-circle"></i>&nbsp;Ver Tipo de Producto
                </h5>
            </div>
            <div class="modal-body">
                <div class="row no-margin-bottom">
                    <div class="col-lg-12">
                        <p><strong>Nombre:</strong> {{ $name }}</p>
                        <p><strong>Descripción:</strong> {{ $description }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" wire:click="cancel()">
                    <i class="fa fa-close"></i>&nbsp;Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
