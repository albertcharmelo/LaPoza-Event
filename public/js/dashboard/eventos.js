(function ($) {
    "use strict";
    var table = $("#eventosTable").DataTable({
        createdRow: function (row, data) {
            $(row).addClass("cursor-pointer");
            // $(row).on("click", function () {
            //     window.location.href = "/eventos/" + data.id;
            // });
            $(row)
                .find("td:eq(0), td:eq(1), td:eq(2), td:eq(3)")
                .on("click", function () {
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
            { data: "comensales", className: "dt-body-center" },
            { data: "fecha", className: "dt-body-center" },
            {
                data: "status",
                render: function (data, type, row) {
                    let isCheked = data === 1 ? "checked" : "";
                    return `<td><label class="custom-toggle">
                            <input type="checkbox" ${isCheked} onchange="changeEstado('${row.id}', this.checked)">
                            <span class="custom-toggle-slider rounded-circle" data-label-off="NO" data-label-on="SI"></span>
                        </label></td>`;
                },
                className: "dt-body-center",
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

function changeEstado(id, isChecked) {
    let status = isChecked == true ? "1" : "0";
    $.ajax({
        type: "POST",
        url: "/eventos/changeStatus",
        data: {
            id: id,
            status: status,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {},
    });
}

function showLoader() {
    $("#loader_page").show();
}
function hideLoader() {
    $("#loader_page").hide();
}
