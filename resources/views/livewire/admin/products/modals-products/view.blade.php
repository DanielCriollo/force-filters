<!-- Modal para mostrar imagen grande -->
<div class="modal fade" id="image-modal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Imagen del Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modal-image" src="" alt="" style="width: 100%; height: auto;" />
            </div>
        </div>
    </div>
</div>

<script>
    function openImageModal(imageSrc) {
        const modalImage = document.getElementById('modal-image');
        if (modalImage) { // Asegúrate de que el elemento existe
            modalImage.src = imageSrc;
            $('#image-modal').modal('show');
        } else {
            console.error('El elemento con ID modal-image no fue encontrado.');
        }
    }
</script>
