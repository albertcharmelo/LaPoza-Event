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
            {
                data: "nombre",
                render: function (data) {
                    return `<span class="clickable-cell">${data}</span>`;
                },
            },
            {
                data: "telefono",
                render: function (data) {
                    return `<span class="clickable-cell">${data}</span>`;
                },
            },
            {
                data: "numero_personas",
                className: "dt-body-center",
                render: function (data) {
                    return `<span class="clickable-cell">${data}</span>`;
                },
            },
            {
                data: "asistencia_confirmada",
                className: "dt-body-center",
                render: function (data) {
                    var text = data === 1 ? "Activo" : "Inactivo";
                    var color = data === 1 ? "text-success" : "text-warning";
                    return `<span class="clickable-cell ${color}">${text}</span>`;
                },
            },
            {
                data: "id",
                className: "dt-body-center",
                render: function (data) {
                    return `<button type="button" class="btn btn-danger shadow btn-xs sharp" onclick="eliminarInvitado('${data}')" data-toggle="tooltip" data-placement="top" title="Eliminar invitado"><i class="fa fa-trash"></i></button>
                            <button type="button" class="btn btn-info shadow btn-xs sharp" onclick="editarInvitado('${data}')" data-toggle="tooltip" data-placement="top" title="Editar invitado"><i class="fa fa-edit"></i></button>`;
                },
            },
        ],
    });

    $(document).on("click", ".clickable-cell", function () {
        var tr = $(this).closest("tr");
        var row = table.row(tr);
        var data = row.data();
        var id = data.id;
        window.location.href = "/qrcode/invitacion/" + id;
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

function eliminarInvitado(id) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "El invitado será eliminado",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar",
        confirmButtonColor: "#fd683e",        
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "/invitados/eliminar",
                type: "POST",
                data: {
                    invitado_id: id,
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
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
                            title: "Exito!",
                            text: "El invitado ha sido eliminado",
                            icon: "success",
                            confirmButtonText: "Aceptar",
                        });
                        $("#invitadosTable").DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: "No se ha podido eliminar el invitado",
                            icon: "error",
                            confirmButtonText: "Aceptar",
                        });
                    }
                },
                error: function (error) {
                    Swal.fire({
                        title: "Error!",
                        text: "No se ha podido eliminar el invitado",
                        icon: "error",
                        confirmButtonText: "Aceptar",
                    });
                },
            });
        }
    });
}

function editarInvitado(id) {
    $.ajax({
        url: "/invitados/getInvitado",
        type: "POST",
        data: {
            invitado_id: id,
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
                showEditInvitado(response.invitado);
            } else {
                Swal.fire({
                    title: "Error!",
                    text: "No se ha podido obtener el invitado",
                    icon: "error",
                    confirmButtonText: "Aceptar",
                });
            }
        },
        error: function (error) {
            Swal.fire({
                title: "Error!",
                text: "No se ha podido obtener el invitado",
                icon: "error",
                confirmButtonText: "Aceptar",
            });
        },
    });
}

function showEditInvitado(invitado) {    
    $("#editIdInv").val(invitado.id);
    $("#editNombreInv").val(invitado.nombre);
    $("#editTlfInv").val(invitado.telefono);
    $("#editEmailInv").val(invitado.email);
    $("#editObsInv").val(invitado.observaciones);
    $("#editInvitado").modal("show");
}

$("#btnGuardarEdit").click(function () {
    const id = $("#editIdInv").val();
    const nombre = $("#editNombreInv").val();
    const telefono = $("#editTlfInv").val();
    const email = $("#editEmailInv").val();
    const observaciones = $("#editObsInv").val();

    $.ajax({
        url: "/invitados/updateInvitado",
        type: "POST",
        data: {
            invitado_id: id,
            nombre: nombre,
            telefono: telefono,
            email: email,
            observaciones: observaciones,
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
                    title: "Exito!",
                    text: "El invitado ha sido actualizado",
                    icon: "success",
                    confirmButtonText: "Aceptar",
                });
                $("#invitadosTable").DataTable().ajax.reload();
                $("#editInvitado").modal("hide");
            } else {
                Swal.fire({
                    title: "Error!",
                    text: "No se ha podido actualizar el invitado",
                    icon: "error",
                    confirmButtonText: "Aceptar",
                });
            }
        },
        error: function (error) {
            Swal.fire({
                title: "Error!",
                text: "No se ha podido actualizar el invitado",
                icon: "error",
                confirmButtonText: "Aceptar",
            });
        },
    });
});
