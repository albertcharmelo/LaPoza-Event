(function ($) {
    ("use strict");
    var table = $("#plantillasTable").DataTable({
        createdRow: function (row, data) {
            $(row).addClass("cursor-pointer");
            $(row)
                .find("td:eq(0), td:eq(1), td:eq(2), td:eq(3)")
                .on("click", function () {
                    console.log(data.id);

                    window.location.href = "/plantillas/platos/" + data.id;
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
            url: "/plantillas/get",
            type: "get",
            data: {
                restaurante_id: getCurrentRestautante(),
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            dataSrc: "",
            dataFilter: function (data) {
                return data;
            },
        },
        columns: [
            { data: "name" },
            { data: "tipo_plantilla", className: "dt-body-center" },
            { data: "description" },
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
