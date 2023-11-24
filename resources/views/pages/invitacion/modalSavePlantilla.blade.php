<div class="modal fade" id="modalSaveTemplate" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Guardar Plantilla de Menú</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <h6>
                    Para guardar la plantilla de menú, debes rellenar los siguientes campos:
                </h6>
                <h3>Nombre de la plantilla</h3>
                <input type="text" class="form-control form-control-lg" id="nombrePlantilla">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="savePlantillas()">Crear Plantilla</button>
            </div>
        </div>
    </div>
</div>