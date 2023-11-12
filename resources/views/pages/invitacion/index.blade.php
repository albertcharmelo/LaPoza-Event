@extends('layouts.dashboard')
@section('css')
<link href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('vendor/jquery-smartwizard/dist/css/smart_wizard.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .sw-theme-default {
        border: none;
    }

    .sw-theme-default>.nav {
        box-shadow: none;
    }

    .sw-theme-default>.nav {
        box-shadow: none;
    }

    .sw-theme-default .toolbar>.btn {

        background-color: #FC410C;
        border: 1px solid #FC410C;

    }
</style>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Inicio</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Invitaciones</a></li>
        </ol>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-xl-12 col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Invitación</h4>
                </div>
                <div class="card-body">
                    <div id="smartwizard" class="form-wizard order-create">
                        <ul class="nav nav-wizard">
                            <li><a class="nav-link" href="#wizard_invitacion_pte1">
                                    <span>1</span>
                                </a>
                            </li>
                            <li><a class="nav-link" href="#wizard_invitacion_pte2">
                                    <span>2</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="wizard_invitacion_pte1" class="tab-pane" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <div class="mb-3">
                                            <label class="text-label form-label">Título</label>
                                            <input type="text" name="titulo" class="form-control"
                                                placeholder="Título de la Invitación" id="titulo" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="comment"
                                                class="text-black font-w600 form-label">Descripción</label>
                                            <textarea rows="8" class="form-control" name="descripcion"
                                                placeholder="Descripción de la Imvitación" id="descripcion"></textarea>
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
                                    <div class="mb-3">
                                        <label class="form-label">Tipo de Menú</label>
                                        <select class="default-select  form-control wide" id="tipoMenu" name="tipoMenu">
                                            <option value="Menu Fijo cob Orecio">Menu Fijo con Precio</option>
                                            <option value="Menu Fijo sin Precio">Menu Fijo sin Precio</option>
                                            <option value="Menu a Elegir con Precio">Menu a Elegir con Precio</option>
                                            <option value="Menu a Elegir sin Precio">Menu a Elegir sin Precio</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
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
</div>
@endsection
@section('scripts')
<script>
    var _token = '{{ csrf_token() }}';
</script>
<script src="{{ asset('vendor/jquery-steps/build/jquery.steps.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/jquery-validation/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/jquery-smartwizard/dist/js/jquery.smartWizard.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('js/dashboard/invitaciones.js') }}" type="text/javascript">
</script>
<script>
    $(document).ready(function() {
            // SmartWizard initialize
            $('#smartwizard').smartWizard();
        });
</script>
@endsection