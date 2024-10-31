<div wire:ignore.self class="modal fade" id="delete-modal" data-bs-backdrop="static" tabindex="-1" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" wire:ignore.self>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{ __('voyager::generic.delete_question') }} la categoría?
                </h5>
                <button type="button" class="btn-close" wire:click="cancel"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" wire:click="cancel()">
                    {{ __('voyager::generic.cancel') }}
                </button>
                <button class="btn btn-danger" wire:click="destroy()">
                    {{ __('voyager::generic.delete_confirm') }}
                </button>
            </div>
            
        </div>
    </div>
</div>
