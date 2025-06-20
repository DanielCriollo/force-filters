<div wire:ignore.self class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="markAsPaidLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="markAsPaidLabel">Marcar como pagado</h5>
                <button type="button" class="btn-close" wire:click="cancel"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Fecha de pago:</label>
                    <input type="datetime-local" class="form-control" wire:model="creditPaidAt">
                    @error('creditPaidAt') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" wire:click="cancel">Cancelar</button>
                <button type="button" class="btn btn-success" wire:click="markAsPaid">Guardar</button>
            </div>
        </div>
    </div>
</div>
