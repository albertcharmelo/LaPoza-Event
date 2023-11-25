(function ($) {
    "use strict";
    var table = $("#invitacionesTable").DataTable({
        createdRow: function (row, data) {
            $(row).addClass("cursor-pointer");
            // $(row).on("click", function () {
            //     window.location.href = "/eventos/" + data.id;
            // });
            $(row)
                .find("td:eq(0), td:eq(1), td:eq(2), td:eq(3)")
                .on("click", function () {
                    // window.location.href = "/invitaciones/index" + data.id;
                });
        },
        language: {
            paginate: {
                next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                previous:
                    '<i class="fa fa-angle-double-left" aria-hidden="true"></i>',
            },
            searchPlaceholder: "Buscar invitaciones",
            search: "Buscar:",
            info: "Mostrando _START_ a _END_ de _TOTAL_ eventos",
            lengthMenu: "Mostrar _MENU_ invitaciones",
        },
        ajax: {
            url: "/invitaciones/getInvitaciones",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            dataSrc: "",
        },
        columns: [
            { data: "titulo" },
            { data: "tipo_menu" },
            { data: "updated_at_formatted"},
            { data: "evento.nombre"},
            { data: "evento.fecha_formatted"}
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
})(jQuery);
