@extends('layouts.dashboard')
@section('css')
<link href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('vendor/jquery-smartwizard/dist/css/smart_wizard.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/dashboard/invitaciones.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@include('pages.invitacion.modalPlantillasInvitacion')
@include('pages.invitacion.modalSavePlantilla')
<div class="container-fluid p-3">
    <div class="row">
        <div class="col-xl-12 col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">{{ $title }}</h1>
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
                                            <h3 class="text-black font-w600 form-label">Título de la
                                                invitación</h3>
                                            <input type="text" name="titulo" class="form-control"
                                                placeholder="Introduzca el título aquí" id="titulo" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <h3 class="text-black font-w600 form-label">Restaurante</h3>
                                            <select class="form-control" aria-label="Restaurante" id="restaurant">
                                                @foreach ($restaurantes_array as $restaurante)
                                                <option value="{{ $restaurante->id }}">{{ $restaurante->nombre }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <h3 for="comment" class="text-black font-w600 form-label">Mensaje de la
                                                invitación</h3>
                                            <textarea class="form-control " id="ckeditorInvitacion"
                                                name="descripcion"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <h3 for="comment" class="text-black font-w600 form-label">Documentos de la
                                                Invitación</h3>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="files" lang="es"
                                                    name="files[]" multiple>
                                                <div class="row" for="files" id="listDocumentos"
                                                    style="display: flex; flex-wrap: wrap;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="wizard_invitacion_pte2" class="tab-pane" role="tabpanel">
                                <div class="row">
                                    <div class="col-12">
                                        <div id="boxUploadMenu" style="min-height: 200px;">
                                            <label class="text-black font-w600 form-label">Imagenes del Menú</label>
                                            <div onclick="openInputMenu()"
                                                class="cursor-pointer dropzoneInput w-100 d-flex flex-column  justify-content-center align-items-center border-dotted">
                                                <input type="file" id="input_file_menu" class="d-none"
                                                    name="files_menu[]" multiple>
                                                <div class="div mb-3">
                                                    <i class="fas fa-upload"
                                                        style="font-size: 30px !important; color:black"></i>
                                                </div>
                                                <span class="text-black text-center">
                                                    Haz click aqui para cargar el menú
                                                </span>
                                                <p class="mt-0 p-0" id="name_menu_uploaded"></p>
                                            </div>
                                        </div>
                                        <div class="row" id="listImagenesMenu" style="display: flex; flex-wrap: wrap;">
                                        </div>

                                        <div class="col-12 mb-3 mt-3">
                                            <h3 class="text-black font-w600 form-label">Tipo de Menú</h3>
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

                                        <div id="boxUploadOptions" class="border border-primary py-4 rounded px-4">
                                            <h3>Agregas los platos y opciones del menú</h3>
                                            <p class="text-muted">Agrega las opciones para los platos pulsando en <span
                                                    class="color-global">Agregar
                                                    opción</span>, para agregar otro platillo
                                                pulse <span class="text-secondary">Añadir plato</span> </p>

                                            <button class="btn btn-primary btn-md mb-3" data-bs-toggle="modal"
                                                data-bs-target="#exampleModalCenter">Usar
                                                Plantilla</button>


                                            <div class="mt-3">
                                                <h4 class="d-flex gap-2">
                                                    <input type="text" class=" form-control  form-control-lg"
                                                        style="font-size: 22px !important;" id="input_add_question"
                                                        placeholder="Ejemplo: Elija el Entrante de su menú " value="">

                                                    {{-- <div class="border border-primary rounded-circle"
                                                        style="width: 22px; height: 22px;"></div> <span
                                                        id="actualPlato">1º</span> plato a elegir --}}
                                                </h4>
                                                <div class="bootstrap-badge mb-3 mt-1" id="listBadges">


                                                </div>
                                                <div class="d-flex gap-3 align-items-center">

                                                    <div class=" d-flex flex-column flex-lg-row w-100 w-lg-75 gap-2">
                                                        <input type="text"
                                                            class="form-control form-control-sm w-100 w-lg-75 "
                                                            id="input_add_option" style="font-size: 18px !important;"
                                                            placeholder="introduzca una opción"
                                                            name="input_add_option" />
                                                        <input type="text"
                                                            class="form-control form-control-sm w-100 w-lg-25 "
                                                            id="input_add_price" style="font-size: 18px !important;"
                                                            placeholder="0.00" name="input_add_price" />

                                                        <div class="d-flex flex-column flex-lg-row w-100 w-lg-75 gap-2">
                                                            <button class="btn btn-sm btn-primary w-lg-25 w-100"
                                                                id="btn_add_option">Agregar
                                                                opción dentro del grupo</button>
                                                            <button class="btn btn-sm btn-secondary w-lg-25 w-100"
                                                                id="btn_add_other_plate">Agregar grupo de
                                                                platos</button>

                                                        </div>

                                                    </div>

                                                </div>


                                            </div>
                                            <div class="mt-4">
                                                <h2 class="mb-3">Menú del Evento</h2>
                                                <ul class="my-4" id="listResultsPlates">
                                                </ul>
                                            </div>

                                            <button type="button" class="btn btn-primary btn-block my-5 d-none"
                                                id="btn_save_template" data-bs-toggle="modal"
                                                data-bs-target="#modalSaveTemplate">Guardar
                                                plantilla de
                                                menú</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="wizard_invitacion_pte3" class="tab-pane" role="tabpanel">
                                <div class="row">
                                    <div class="row col-12 mb-2 mb-lg-3">
                                        <div class="col-12 col-md-6 mb-2 mb-lg-0">
                                            <div class="form-group">
                                                <label class="text-black font-w600 form-label" for="nombre_org">Nombre
                                                    del organizador</label>
                                                <input class="form-control" type="text" id="nombre_org"
                                                    name="nombre_org" placeholder="introduzca el nombre aquí" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 mb-2 mb-lg-0">
                                            <div class="form-group">
                                                <label class="text-black font-w600 form-label" for="email_org">Email
                                                    del organizador</label>
                                                <input class="form-control" type="email" id="email_org" name="email_org"
                                                    placeholder="introduzca el email aquí" required>                                              
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-2 mb-2 mb-lg-0" style="display: flex; align-items: flex-end;">
                                            <button class="btn btn-primary mt-2" id="btn_agregar_email" style="height: 42px;">Agregar email</button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 ml-auto justify-content-between" id="listEmails">
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-4 mb-2 mb-lg-0">
                                            <div class="form-group">
                                                <label class="text-black font-w600 form-label"
                                                    for="telefon_org">Teléfono del organizador</label>
                                                <input class="form-control" type="text" id="telefono_org"
                                                    name="telefono_org" placeholder="introduzca el teléfono quí">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 mb-2 mb-lg-0">
                                            <div class="form-group">
                                                <label class="text-black font-w600 form-label" for="fecha_evento">Fecha
                                                    del Evento</label>
                                                <input class="form-control" type="date" id="fecha_evento" value=""
                                                    name="fecha_evento" placeholder="introduzca la fecha del evento">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 mb-2 mb-lg-0">
                                            <div class="form-group">
                                                <label class="text-black font-w600 form-label"
                                                    for="telefon_org">Solicitar datos a los invitados?</label>
                                                <select class="form-control" type="text" id="datos_requeridos"
                                                    name="datos_requeridos">
                                                    <option value="1">Si, Solicitar datos de forma obligatoria</option>
                                                    <option value="0">No, Los datos no son un campo obligatorio</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer border-0 mt-5 float-right">
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
    var invitacion_edit = {!! json_encode($invitacion) !!};
  
</script>
<script src="https://unpkg.com/imask"></script>
<!-- jsDelivr :: Sortable :: Latest (https://www.jsdelivr.com/package/npm/sortablejs) -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script src="{{ asset('vendor/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/dashboard/ckeditor.init.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/jquery-steps/build/jquery.steps.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/jquery-validation/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/jquery-smartwizard/dist/js/jquery.smartWizard.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/dashboard/invitaciones/invitaciones.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/dashboard/invitaciones/invitaciones_opciones_menu.js') }}" type="text/javascript"></script>
@endsection