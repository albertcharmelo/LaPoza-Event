(function ($) {
    "use strict";
    var table = $("#eventosTable").DataTable({
        createdRow: function (row, data) {
            $(row).addClass("cursor-pointer");
            $(row).on("click", function () {
                window.location.href = "/eventos/" + data.id;
            });
        },
        language: {
            paginate: {
                next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                previous:
                    '<i class="fa fa-angle-double-left" aria-hidden="true"></i>',
            },
            searchPlaceholder: "Buscar eventos",
            search: "Buscar:",
            info: "Mostrando _START_ a _END_ de _TOTAL_ eventos",
            lengthMenu: "Mostrar _MENU_ eventos",
        },
        ajax: {
            url: "/eventos",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            dataSrc: "",
        },
        columns: [
            { data: "nombre" },
            { data: "email_organizador" },
            { data: "comensales" },
            { data: "fecha" },
            {
                data: "status",
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
})(jQuery);

function showLoader() {
    $("#loader_page").show();
}
function hideLoader() {
    $("#loader_page").hide();
}
