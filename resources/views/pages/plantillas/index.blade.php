@extends('layouts.dashboard')
<!-- Datatable -->

@section('css')
<link href="{{ asset('vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Todas las Plantillas</h4>
                </div>

                <div class="card-body px-3">
                    <div class="mb-2 w-100 d-flex gap-2 justify-content-center justify-content-lg-end">
                        <a href="{{ route('plantillas.crear','platos') }}" class="btn btn-primary btn-sm">Crear
                            Plantilla de Platos</a>
                        <button class="btn btn-secondary btn-sm">Crear Plantilla de Evento</button>
                    </div>
                    <div class="table-responsive">
                        <table id="plantillasTable" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th width="30%">Nombre de Plantilla</th>
                                    <th width="20%" class="text-center">Tipo de Plantilla</th>
                                    <th width="30%" class="text-center">Descripción</th>

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th width="35%">Nombre de Plantilla</th>
                                    <th width="30%" class="text-center">Tipo de Plantilla</th>
                                    <th width="35%" class="text-center">Descripción</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<!-- Datatable -->
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/dashboard/plantillas/plantilla_index.js') }}" type="text/javascript"></script>
@endsection