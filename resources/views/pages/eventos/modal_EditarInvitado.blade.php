<div class="modal fade" id="editInvitado" tabindex="-1" role="dialog" aria-labelledby="editInvitadoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar Invitado</h4>
                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">X</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editIdInv" name="editIdInv">
                <div class="row mb-3">
                    <label for="editNombreInv" class="col-sm-2 col-form-label text-black font-w600">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="editNombreInv" name="editNombreInv"
                            placeholder="Nombre">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="editEmailInv" class="col-sm-2 col-form-label text-black font-w600">Correo</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="editEmailInv" name="editEmailInv"
                            placeholder="Correo">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="editTlfInv" class="col-sm-2 col-form-label text-black font-w600">Teléfono</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="editTlfInv" name="editTlfInv"
                            placeholder="Teléfono">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="editObsInv" class="col-sm-2 col-form-label text-black font-w600">Observaciones / Alergias / Intolerancias </label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="editObsInv" name="editObsInv" rows="3" placeholder="Observaciones"
                            style="min-height: 90px"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarEdit">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>
