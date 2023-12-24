@extends('layouts.dashboard')
@section('css')
<link href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/dashboard/invitaciones.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
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
<div class="container-fluid p-3">
    <div class="card">
        <div class="card-body">
            <div class="col-12 mb-3 mt-3">
                <h3 class="text-black font-w600 form-label">Tipo de Menú</h3>
                <select class="  form-control wide" id="tipoMenu" name="tipoMenu">
                    <option value="" selected disabled hidden>Selecciona una opción
                    </option>

                    <option value="Menu a Elegir con Precio" selected>Menu a Elegir con Precio
                    </option>
                    <option value="Menu a Elegir sin Precio">Menu a Elegir sin Precio
                    </option>
                </select>
            </div>

            <div id="boxUploadOptions" class="border border-primary py-4 rounded px-4">
                <h3>Agregas los platos y opciones del menú</h3>
                <p class="text-muted">Agrega las opciones al grupo de platos pulsando <span class="color-global">Agregar
                        opción dentro del grupo</span>, para agregar el grupo de platos dentro del menú
                    pulse <span class="text-secondary">Agregar grupo de platos al menú</span> </p>




                <div class="mt-3">
                    <h4 class="d-flex gap-2">
                        <input type="text" class=" form-control  form-control-lg" style="font-size: 22px !important;"
                            id="input_add_question" placeholder="Ejemplo: Elija el Entrante de su menú " value="">

                        {{-- <div class="border border-primary rounded-circle" style="width: 22px; height: 22px;"></div>
                        <span id="actualPlato">1º</span> plato a elegir --}}
                    </h4>
                    <div class="bootstrap-badge mb-3 mt-1" id="listBadges">


                    </div>
                    <div class="d-flex gap-3 align-items-center">

                        <div class=" d-flex flex-column flex-lg-row w-100 w-lg-75 gap-2">
                            <input type="text" class="form-control form-control-sm w-100 w-lg-75 " id="input_add_option"
                                style="font-size: 18px !important;" placeholder="introduzca una opción"
                                name="input_add_option" />
                            <input type="text" class="form-control form-control-sm w-100 w-lg-25 " id="input_add_price"
                                style="font-size: 18px !important;" placeholder="0.00" name="input_add_price" />

                            <div class="d-flex flex-column flex-lg-row w-100 w-lg-75 gap-2">
                                <button class="btn btn-sm btn-primary w-lg-25 w-100" id="btn_add_option">Agregar
                                    opción dentro del grupo</button>
                                <button class="btn btn-sm btn-secondary w-lg-25 w-100" id="btn_add_other_plate">Agregar
                                    grupo de
                                    platos al menú</button>

                            </div>

                        </div>

                    </div>


                </div>
                <div class="mt-4">
                    <h2 class="mb-3">Menú del Evento</h2>
                    <ul class="my-4" id="listResultsPlates">
                    </ul>
                </div>

                <button type="button" class="btn btn-primary btn-block my-5 d-none" id="btn_save_template"
                    data-bs-toggle="modal" data-bs-target="#modalSaveTemplate">Guardar
                    plantilla de
                    menú</button>
            </div>
        </div>



    </div>
</div>

@endsection
@section('scripts')
<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/dashboard/invitaciones/invitaciones_opciones_menu.js') }}" type="text/javascript"></script>
<script>
    let inputPrice = $("#input_add_price");
    select_tipoMenu.on("change", function () {
    platos_with_options = [];
    listResultsPlates.html("");
    opciones_de_platos = [];

    if (
        select_tipoMenu.val() == "Menu a Elegir con Precio" ||
        select_tipoMenu.val() == "Menu a Elegir sin Precio"
    ) {
        if (select_tipoMenu.val() == "Menu a Elegir con Precio") {
            inputPrice.show();
        } else {
            inputPrice.hide();
        }

        actualPlato.text("1º");
        input_add_option.val("");
        listBadges.html("");

        input_add_option.focus();
    }
});
</script>
@endsection