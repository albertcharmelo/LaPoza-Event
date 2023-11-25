{{-- <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document"> --}}

<div id="ModalInvitadosByPlato" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Invitados por plato: <span id="nombre_plato"></span></h4>
                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">X</button>
            </div>
            <div class="modal-body">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="tableInvitadosByPlato" class="display"
                            style="min-width: 845px; width: 100% !important;">
                            <thead>
                                <tr>
                                    <th with="80%">Nombre del invitado</th>
                                    <th with="10%" class="text-center">Teléfono</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th with="80%">Nombre del invitado</th>
                                    <th with="10%" class="text-center">Teléfono</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-
