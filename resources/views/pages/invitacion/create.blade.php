@extends('layouts.dashboard')
@section('css')
<link href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('vendor/jquery-smartwizard/dist/css/smart_wizard.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/dashboard/invitaciones.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    {{-- <div class="row page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Inicio</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Invitaciones</a></li>
        </ol>
    </div>
    <!-- row --> --}}
    <div class="row">
        <div class="col-xl-12 col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Invitación</h4>
                </div>
                <div class="card-body" style="height: auto">
                    <div id="smartwizard" class="form-wizard order-create">
                        <ul class="nav nav-wizard" style="flex-direction: row !important">
                            <li><a class="nav-link" href="#wizard_invitacion_pte1">
                                    <span>1</span>
                                </a>
                            </li>
                            <li><a class="nav-link" href="#wizard_invitacion_pte2">
                                    <span>2</span>
                                </a>
                            </li>
                            <li><a class="nav-link" href="#wizard_invitacion_pte3">
                                    <span>3</span>
                                </a>
                            </li>

                        </ul>

                        <div class="tab-content ">
                            <div id="wizard_invitacion_pte1" class="tab-pane" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <div class="mb-3">
                                            <label class="text-black font-w600 form-label">Título de la
                                                invitación</label>
                                            <input type="text" name="titulo" class="form-control"
                                                placeholder="Introduzca el título aquí" id="titulo" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="comment" class="text-black font-w600 form-label">Mensaje de
                                                invitacion</label>
                                            <textarea class="form-control " id="ckeditorInvitacion"
                                                name="descripcion"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">

                                            <label for="comment"
                                                class="text-black font-w600 form-label">Archivos</label>
                                            <div class="custom-file">

                                                <input type="file" class="custom-file-input" id="files" lang="es"
                                                    name="files[]" multiple>
                                                <label id="listoDocumentos" for="files">Seleccionar Archivos</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="wizard_invitacion_pte2" class="tab-pane" role="tabpanel">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="text-black font-w600 form-label">Tipo de Menú</label>
                                        <select class="  form-control wide" id="tipoMenu" name="tipoMenu">
                                            <option value="" selected disabled hidden>Selecciona una opción
                                            </option>
                                            <option value="Menu Fijo con Precio">Menu Fijo con Precio</option>
                                            <option value="Menu Fijo sin Precio">Menu Fijo sin Precio</option>
                                            <option value="Menu a Elegir con Precio">Menu a Elegir con Precio
                                            </option>
                                            <option value="Menu a Elegir sin Precio">Menu a Elegir sin Precio
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <div id="boxUploadMenu" style="min-height: 200px;display:none">
                                            <label class="text-black font-w600 form-label">Imagen del Menú</label>
                                            <div onclick="openInputMenu()"
                                                class="cursor-pointer dropzoneInput w-100 d-flex flex-column  justify-content-center align-items-center border-dotted">
                                                <input type="file" id="input_file_menu" class="d-none"
                                                    name="input_file_menu" />
                                                <div class="div mb-3">
                                                    <i class="fas fa-upload" style="font-size: 30px;color:white"></i>
                                                </div>
                                                <span class="text-white text-center">
                                                    Haz click aqui para cargar el menú
                                                </span>
                                                <p class="mt-0 p-0" id="name_menu_uploaded"></p>
                                            </div>
                                        </div>
                                        <div id="boxUploadOptions" class="border border-primary py-4 rounded px-4">
                                            <h3>Agregas los platos y opciones del menú</h3>
                                            <p class="text-muted">Agrega las opciones para los platos pulsando en <span
                                                    class="color-global">Agregar
                                                    opción</span>, para agregar otro platillo
                                                pulse <span class="text-secondary">Añadir plato</span> </p>


                                            <div class="mt-3">
                                                <h4 class="d-flex gap-2">
                                                    <div class="border border-primary rounded-circle"
                                                        style="width: 22px; height: 22px;"></div> <span
                                                        id="actualPlato">1º</span> plato a elegir
                                                </h4>
                                                <div class="bootstrap-badge mb-3 mt-1" id="listBadges">


                                                </div>
                                                <div class="d-flex gap-3 align-items-center">

                                                    <div class=" d-flex flex-column flex-lg-row w-100 w-lg-75 gap-2">
                                                        <input type="text"
                                                            class="form-control form-control-sm w-100 w-lg-75 "
                                                            id="input_add_option" placeholder="introduzca una opción"
                                                            name="input_add_option" />
                                                        <input type="text"
                                                            class="form-control form-control-sm w-100 w-lg-25 "
                                                            id="input_add_price" placeholder="0.00"
                                                            name="input_add_price" />

                                                        <div class="d-flex flex-column flex-lg-row w-100 w-lg-75 gap-2">
                                                            <button class="btn btn-sm btn-primary w-lg-25 w-100"
                                                                id="btn_add_option">Agregar
                                                                opción</button>
                                                            <button class="btn btn-sm btn-secondary w-lg-25 w-100"
                                                                id="btn_add_other_plate">Añadir otro
                                                                plato</button>

                                                        </div>

                                                    </div>

                                                </div>


                                            </div>

                                            <div id="listResultsPlates">

                                                <div>


                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="wizard_invitacion_pte3" class="tab-pane" role="tabpanel">
                                <div class="row">
                                    <div class="row col-12 mb-5">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="text-black font-w600 form-label" for="nombre_org">Nombre
                                                    del organizador</label>
                                                <input class="form-control" type="text" id="nombre_org"
                                                    name="nombre_org" placeholder="introduzca el nombre aquí" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="text-black font-w600 form-label" for="email_org">Email
                                                    del organizador</label>
                                                <input class="form-control" type="email" id="email_org" name="email_org"
                                                    placeholder="introduzca el email aquí" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="text-black font-w600 form-label"
                                                    for="telefon_org">Teléfono del organizador</label>
                                                <input class="form-control" type="text" id="telefono_org"
                                                    name="telefono_org" placeholder="introduzca el teléfono quí">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-black font-w600 form-label" for="fecha_evento">Fecha
                                                    del Evento</label>
                                                <input class="form-control" type="date" id="fecha_evento" value=""
                                                    name="fecha_evento" placeholder="introduzca la fecha del evento">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer my-4">
                                    {{-- <button type="button" id="btnCerrar"
                                        class="btn btn-danger light">Cerrar</button> --}}
                                    <button type="button" id="btnGuardar" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    var _token = '{{ csrf_token() }}';
</script>
<script src="https://unpkg.com/imask"></script>
<script src="{{ asset('vendor/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/dashboard/ckeditor.init.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/jquery-steps/build/jquery.steps.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/jquery-validation/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/jquery-smartwizard/dist/js/jquery.smartWizard.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/dashboard/invitaciones/invitaciones.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/dashboard/invitaciones/invitaciones_opciones_menu.js') }}" type="text/javascript"></script>

<script>
    $(document).ready(function() {
            // SmartWizard initialize
            $('#smartwizard').smartWizard();
        });
</script>
@endsection