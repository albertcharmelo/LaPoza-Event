(function ($) {
    "use strict";
    const evento_id = $("#evento_id").val();
    const tipo_menu = $("#tipo_menu").val();
    var nombre_plato = $("#nombre_plato");
    let resumenPlatos = $("#resumenPlatos");
    resumenPlatos.hide();
    if (
        tipo_menu == "Menu a Elegir con Precio" ||
        tipo_menu == "Menu a Elegir sin Precio"
    ) {
        resumenPlatos.show();
    }

    var table = $("#invitadosTable").DataTable({
        createdRow: function (row, data) {
            $(row).addClass("cursor-pointer");
            $(row).on("click", function () {
                window.location.href = "/qrcode/invitacion/" + data.id;
            });
        },
        language: {
            paginate: {
                next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                previous:
                    '<i class="fa fa-angle-double-left" aria-hidden="true"></i>',
            },
            searchPlaceholder: "Buscar invitado",
            search: "Buscar:",
            info: "Mostrando _START_ a _END_ de _TOTAL_ invitados",
            lengthMenu: "Mostrar _MENU_ invitados",
        },
        ajax: {
            url: "/invitados",
            type: "POST",
            data: function (d) {
                d.evento_id = evento_id;
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            dataSrc: "",
            beforeSend: function () {
                showLoader();
            },
            complete: function (data) {
                hideLoader();
                var data = data.responseJSON;
                if (data.length > 0) {
                    data.forEach(function (element) {
                        showMobile_device_table(element);
                    });
                }
            },
        },
        columns: [
            { data: "nombre" },
            { data: "telefono" },
            { data: "numero_personas", className: "dt-body-center" },
            {
                data: "asistencia_confirmada",
                render: function (data) {
                    var text = data === 1 ? "Activo" : "Inactivo";
                    var color = data === 1 ? "text-success" : "text-warning";
                    return `<span class="${color}">${text}</span>`;
                },
                className: "dt-body-center",
            },
        ],
    });

    function showMobile_device_table(element) {
        let html = `<div class="card-movil">
                        <div class="card-body" style="padding: 0.5rem !important;">
                            <div class="row">                    
                                <div class="col-6">
                                    <p class="card-text mb-0"><strong>Nombre:</strong> ${element.nombre}</p>
                                    <p class="card-text mb-0"><strong>Teléfono:</strong> ${element.telefono}</p>
                                    <p class="card-text mb-0"><strong>Número de comensales:</strong> ${element.numero_personas}</p>
                                    <p class="card-text mb-0"><strong>Asistencia confirmada:</strong> ${element.asistencia_confirmada}</p>
                                </div>
                            </div>
                        </div>
                    </div>`;
        $("#mobile_device_table").append(html);
    }

    table.on("click", "tbody tr", function () {
        var $row = table.row(this).nodes().to$();
        var hasClass = $row.hasClass("selected");
        if (hasClass) {
            $row.removeClass("selected");
        } else {
            $row.addClass("selected");
        }
    });

    table.rows().every(function () {
        this.nodes().to$().removeClass("selected");
    });

    if (
        tipo_menu == "Menu a Elegir con Precio" ||
        tipo_menu == "Menu a Elegir sin Precio"
    ) {
        var tableResumen = $("#TableResumenPlatos").DataTable({
            createdRow: function (row, data) {
                $(row).on("click", function () {
                    nombre_plato = data.plato;
                    $("#nombre_plato").text(nombre_plato);

                    var tableInvitadosByPlato = $(
                        "#tableInvitadosByPlato"
                    ).DataTable({
                        destroy: true,
                        language: {
                            paginate: {
                                next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                                previous:
                                    '<i class="fa fa-angle-double-left" aria-hidden="true"></i>',
                            },
                            searchPlaceholder: "Buscar invitado",
                            search: "Buscar:",
                            info: "Mostrando _START_ a _END_ de _TOTAL_ v",
                            lengthMenu: "Mostrar _MENU_ invitados",
                        },
                        ajax: {
                            url: "/invitaciones/getInvitadosByPlatos",
                            type: "POST",
                            data: function (d) {
                                d.evento_id = evento_id;
                                d.plato = nombre_plato;
                            },
                            headers: {
                                "X-CSRF-TOKEN": $(
                                    'meta[name="csrf-token"]'
                                ).attr("content"),
                            },
                            dataType: "json",
                            dataSrc: "",
                            beforeSend: function () {
                                // $("#loading").show();
                                showLoader();
                            },
                            complete: function () {
                                // $("#loading").hide();
                                hideLoader();
                            },
                        },
                        columns: [
                            { data: "nombre" },
                            { data: "telefono", className: "dt-body-center" },
                        ],
                    });
                    tableInvitadosByPlato.rows().every(function () {
                        this.nodes().to$().removeClass("selected");
                    });
                    $("#ModalInvitadosByPlato").modal("show");
                });
            },
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous:
                        '<i class="fa fa-angle-double-left" aria-hidden="true"></i>',
                },
                searchPlaceholder: "Buscar plato",
                search: "Buscar:",
                info: "Mostrando _START_ a _END_ de _TOTAL_ platos",
                lengthMenu: "Mostrar _MENU_ platos",
            },
            ajax: {
                url: "/invitaciones/getPlatos",
                type: "POST",
                data: function (d) {
                    d.evento_id = evento_id;
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                dataType: "json",
                dataSrc: "",
                beforeSend: function () {
                    showLoader();
                },
                complete: function () {
                    hideLoader();
                },
            },
            columns: [
                { data: "plato" },
                { data: "cantidad", className: "dt-body-center" },
            ],
        });

        tableResumen.on("click", "tbody tr", function () {
            var $row = tableResumen.row(this).nodes().to$();
            var hasClass = $row.hasClass("selected");
            if (hasClass) {
                $row.removeClass("selected");
            } else {
                $row.addClass("selected");
            }
        });

        tableResumen.rows().every(function () {
            this.nodes().to$().removeClass("selected");
        });
    }
})(jQuery);

function enviarInvitacionOrganizador() {
    const idDelEvento = $("#evento_id").val();
    $.ajax({
        url: "/invitaciones/enviarInvitacionMail",
        type: "POST",
        data: {
            evento_id: idDelEvento,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        beforeSend: function () {
            showLoader();
        },
        complete: function () {
            hideLoader();
        },
        success: function (response) {
            hideLoader();
            if (response.status == "success") {
                Swal.fire({
                    title: "Enviado!",
                    text: "Se ha enviado la invitación al organizador",
                    icon: "success",
                    confirmButtonText: "Aceptar",
                });
            } else {
                Swal.fire({
                    title: "Error!",
                    text: "No se ha podido enviar la invitación al organizador",
                    icon: "error",
                    confirmButtonText: "Aceptar",
                });
            }
        },
        error: function (error) {
            Swal.fire({
                title: "Error!",
                text: "No se ha podido enviar la invitación al organizador",
                icon: "error",
                confirmButtonText: "Aceptar",
            });
        },
    });
}

function showLoader() {
    $("#loader_page").show();
}
function hideLoader() {
    $("#loader_page").hide();
}
