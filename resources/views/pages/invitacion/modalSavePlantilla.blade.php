<div class="modal fade" id="modalSaveTemplate" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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
                <h3 class="mt-3 mb-1">Nombre de la plantilla</h3>
                <input type="text" class="form-control form-control-lg" id="nombrePlantilla">
                <h3 class="mt-3 mb-1">Descripción de la plantilla</h3>
                <input type="text" class="form-control form-control-lg" id="descripcionPlantilla">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary col-12 " onclick="savePlantillas()">Crear
                    Plantilla</button>
                <button type="button" class="btn btn-primary col-12 " style="display:none" id="btn_reemplazar_plantilla"
                    onclick="savePlantillas(true)">Reemplazar
                    Plantilla</button>
                <button type="button" class="btn btn-danger light col-12 mt-lg-3"
                    data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>