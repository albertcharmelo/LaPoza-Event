(function ($) {
    "use strict";
    const evento_id = $("#evento_id").val();
    const tipo_menu = $("#tipo_menu").val();
    var nombre_plato = $("#nombre_plato");
    let resumenPlatos = $("#resumenPlatos");
    resumenPlatos.hide();
    if (tipo_menu == "Menu a Elegir con Precio" || tipo_menu == "Menu a Elegir sin Precio") {
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
            complete: function () {
                hideLoader();                
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
                }, className: "dt-body-center" },
        ],
    });

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
                $('#nombre_plato').text(nombre_plato);              
                
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
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
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
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
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

function showLoader() {
    $("#loader_page").show();
}
function hideLoader() {
    $("#loader_page").hide();
}
