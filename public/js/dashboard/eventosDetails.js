(function ($) {
    "use strict";
    const evento_id = $("#evento_id").val();

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
        },
        columns: [
            { data: "nombre" },
            { data: "telefono" },
            { data: "numero_personas" },
            {
                data: "asistencia_confirmada",
                render: function (data) {
                    var text = data === 1 ? "Activo" : "Inactivo";
                    var color = data === 1 ? "text-success" : "text-warning";
                    return `<span class="${color}">${text}</span>`;
                },
            },
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

    var tableResumen = $("#TableResumenPlatos").DataTable({
        createdRow: function (row, data) {          
            // $(row).on("click", function () {
            //     window.location.href = "/qrcode/invitacion/" + data.id;
            // });            
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
})(jQuery);
