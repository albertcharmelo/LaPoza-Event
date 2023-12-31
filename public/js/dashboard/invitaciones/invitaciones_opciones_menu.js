let input_add_price = document.getElementById("input_add_price");
let input_add_option = $("#input_add_option");
let input_add_question = $("#input_add_question");
let btn_save_template = $("#btn_save_template");
let select_tipoMenu = $("#tipoMenu");
let btn_add_option = $("#btn_add_option");
let btn_add_other_plate = $("#btn_add_other_plate");
let listPlantillas = $("#listPlantillas");
let listBadges = $("#listBadges");
let listResultsPlates = $("#listResultsPlates");
let actualPlato = $("#actualPlato");
let plantillas = [];
let array_name_platos = [];
let opciones_de_platos = [];
let platos_with_options = []; // variable que guarda el resultado final de los platos con sus opciones
let plantilla_selected = null;
$(document).ready(function () {
    getPlantillas();
});

/**
 * Muestra un mensaje utilizando la librería SweetAlert2.
 * @param {string} type - Tipo de mensaje (success, error, warning, info).
 * @param {string} title - Título del mensaje.
 * @param {string} text - Texto del mensaje.
 */
function SwalShowMessage(type, title, text) {
    Swal.fire({
        type: type,
        title: title,
        text: text,
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#fc410c",
        allowOutsideClick: false,
    });
}

const maskOptions = {
    mask: "€num",
    blocks: {
        num: {
            // nested masks are available!
            mask: Number,
            scale: 2, // digits after point, 0 for integers
            signed: true, // disallow negative
            thousandsSeparator: ".", // any single char
            padFractionalZeros: true, // if true, then pads zeros at end to the length of scale
            normalizeZeros: true, // appends or removes zeros at ends
            radix: ",", // fractional delimiter
            mapToRadix: ["."], // symbols to process as radix
        },
    },
};

const maskInputPrice = IMask(input_add_price, maskOptions);

/* ------------------------------------------- EVENTOS ------------------------------------------ */

// para agregar una opcion a un plato
btn_add_option.click(function () {
    let option = input_add_option.val();
    if (
        input_add_question.val() == "" &&
        (select_tipoMenu.val() == "Menu a Elegir con Precio" ||
            select_tipoMenu.val() == "Menu a Elegir sin Precio")
    ) {
        SwalShowMessage(
            "warning",
            "¡Advertencia!",
            "Debe agregar una pregunta para el plato"
        );
        return;
    }

    if (select_tipoMenu.val() == "Menu a Elegir con Precio") {
        if (option !== "" && input_add_price.value !== "") {
            const precio = maskInputPrice.value; //si reempalzas value por typedValue, obtienes el valor sin formato

            let badge = $(
                "<a href='javascript:void(0)' class='badge badge-rounded badge-primary' onclick='editarOpcion(event)' ondblclick='eliminarOpcion(event)'></a>"
            );
            badge.text(option + " - " + precio);
            badge.appendTo(listBadges);
            opciones_de_platos.push(option + " - " + precio);
            input_add_option.val("");
            maskInputPrice.value = "";
            input_add_option.focus();
        }
    } else {
        if (option !== "") {
            let badge = $(
                "<a href='javascript:void(0)' class='badge badge-rounded badge-primary' onclick='editarOpcion(event)' ondblclick='eliminarOpcion(event)'></a>"
            );
            badge.text(option);
            badge.appendTo(listBadges);
            opciones_de_platos.push(option);
            input_add_option.val("");
            input_add_option.focus();
        }
    }
});

input_add_option.keyup(function (e) {
    if (e.keyCode === 13) {
        btn_add_option.click();
    }
});

btn_save_template.click(function () {
    // verificar si esta con valor la variable plantilla_selected
    $("#nombrePlantilla").val("");
    $("#descripcionPlantilla").val("");
    if (plantilla_selected != null) {
        $("#btn_reemplazar_plantilla").show();

        $.ajax({
            url: "/invitaciones/getDetallesPlantilla",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                id_pantilla: plantilla_selected,
            },
            success: function (response) {
                if (response.status == "success") {
                    $("#nombrePlantilla").val(response.data.name);
                    $("#descripcionPlantilla").val(response.data.description);
                } else {
                    SwalShowMessage(
                        "error",
                        "¡Error!",
                        "Ha ocurrido un error al obtener los datos de la plantilla"
                    );
                }
            },
            error: function (error) {
                SwalShowMessage(
                    "error",
                    "¡Error!",
                    "Ha ocurrido un error al obtener los datos de la plantilla"
                );
            },
        });
    }
});

// para agregar un plato a la lista de platos
btn_add_other_plate.click(function () {
    let list_badges_has_child = listBadges.children().length;

    if (input_add_question.val() == "") {
        SwalShowMessage(
            "warning",
            "¡Advertencia!",
            "Debe agregar una pregunta para el plato"
        );
        return;
    }

    if (list_badges_has_child >= 2) {
        platos_with_options.push({
            [input_add_question.val()]: opciones_de_platos,
        });
        opciones_de_platos = [];
        listBadges.empty();
        input_add_option.val("");
        actualPlato.text(array_name_platos[platos_with_options.length]);
        input_add_question.val("");
        input_add_question.focus();
        addPlateOptionsWithPlate();
        checkIfShowSaveTemplate();
    }
});

/* ------------------------------------------ FUNCIONES ----------------------------------------- */

// para agregar los platos a la lista de platos ya aramados
function addPlateOptionsWithPlate() {
    let html = "";
    platos_with_options.forEach((platos) => {
        for (const pregunta in platos) {
            if (Object.hasOwnProperty.call(platos, pregunta)) {
                const plato = platos[pregunta];
                let badgesOptions = "";
                plato.forEach((option) => {
                    badgesOptions += `<a href="javascript:void(0)" class="badge badge-rounded badge-primary">${option}</a>`;
                });
                html += `
                <li class="mt-3 grupoDePlatos borde-negro py-3 px-2" onclick="editarPlato('${pregunta}')">
                    <h4 class="d-flex gap-2">
                        <div class="border border-primary rounded-circle d-flex justify-content-center align-items-center"
                        style="width: 24px; height: 24px;cursor:pointer">
                            <i class="fa-solid fa-pencil" style='font-size:9px'></i>
                        </div> 
                        ${pregunta}
                    </h4>
                    <div class="bootstrap-badge mb-3 mt-1">
                        ${badgesOptions}
                    </div>
                </li>
                `;
            }
        }
    });

    listResultsPlates.html(html);
}

function savePlantillas(reemplazar = false) {
    let nombrePlantilla = $("#nombrePlantilla").val();
    let descripcionPlantilla = $("#descripcionPlantilla").val();
    if (nombrePlantilla == "") {
        SwalShowMessage(
            "warning",
            "¡Advertencia!",
            "Debe agregar un nombre para la plantilla"
        );
        return;
    }

    let data = {
        name: nombrePlantilla,
        description: descripcionPlantilla,
        tipoMenu: select_tipoMenu.val(),
        platos: platos_with_options,
        reemplazar: reemplazar ? plantilla_selected : null,
    };

    showLoader();
    $.ajax({
        url: "/invitaciones/crearPlantilla",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: data,
        success: function (response) {
            if (response.status == "success") {
                SwalShowMessage(
                    "success",
                    "¡Éxito!",
                    "Se ha creado la plantilla correctamente"
                );
                getPlantillas();
                $("#nombrePlantilla").val("");
                $("#descripcionPlantilla").val("");
                $("#modalSaveTemplate").modal("hide");
                $("#btn_reemplazar_plantilla").hide();
                if (window.location.pathname === "/plantillas/crear/platos") {
                    window.location.href = "/plantillas";
                }
            } else {
                SwalShowMessage(
                    "error",
                    "¡Error!",
                    "Ha ocurrido un error al crear la plantilla"
                );
            }
        },
        error: function (error) {
            SwalShowMessage(
                "error",
                "¡Error!",
                "Ha ocurrido un error al crear la plantilla"
            );
        },
    });
    hideLoader();
}

function getPlantillas() {
    showLoader();
    $.ajax({
        url: "/invitaciones/getPlantillas",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },

        success: function (response) {
            if (response.status == "success") {
                plantillas = response.data;
                createListPlantillas(response.data);
            } else {
                SwalShowMessage(
                    "error",
                    "¡Error!",
                    "Ha ocurrido un error al obtener las plantilla"
                );
            }
        },
        error: function (error) {
            SwalShowMessage(
                "error",
                "¡Error!",
                "Ha ocurrido un error al obtener las plantillas"
            );
        },
    });
    hideLoader();
}

function createListPlantillas(data = plantillas) {
    let html = "";

    data.forEach((plantilla, pregunta) => {
        html += `
            <li class="list-group-item d-flex justify-content-between align-items-center template-card rounded" onclick="getOnePlantilla('${
                plantilla.id
            }')">
            <div class="d-flex flex-column justify-content-center w-75 gap-2">
                <h4 class="mb-0" >${plantilla.name}</h4>
                <h6>${plantilla.description || "Sin descripción"}</h6>
            </div>
                <span class="badge bg-primary rounded-pill">${
                    plantilla.tipo_menu
                }</span>
            </li>
        `;
    });

    listPlantillas.html(html);
}

function getOnePlantilla(params) {
    // obtener en la varibale plantillas la plantilla seleccionada
    let plantilla = plantillas.find((plantilla) => plantilla.id == params);
    // guardar el id de la plantilla
    plantilla_selected = plantilla.id;
    // limpiar los platos con opciones
    platos_with_options = [];
    // limpiar las opciones de los platos
    opciones_de_platos = [];
    // limpiar los badges
    listBadges.empty();
    // limpiar el input de pregunta
    input_add_question.val("");
    // limpiar el input de opciones
    input_add_option.val("");
    // limpiar el input de precio
    maskInputPrice.value = "";
    // limpiar el input de nombre de plantilla
    $("#nombrePlantilla").val("");
    // limpiar el input de nombre de plantilla
    listResultsPlates.html("");
    // llenar el input de tipo de menu
    select_tipoMenu.val(plantilla.tipo_menu);

    select_tipoMenu.trigger("change");
    tipoMenu.val(plantilla.tipo_menu); // esta variable esta en dashboard/invitaciones/invitaciones.js
    // llenar el input de nombre de plantilla
    plantilla.platos.forEach((plato) => {
        for (const pregunta in plato) {
            if (Object.hasOwnProperty.call(plato, pregunta)) {
                const opciones = plato[pregunta];
                opciones.forEach((opcion) => {
                    opciones_de_platos.push(opcion);
                });
                platos_with_options.push({
                    [pregunta]: opciones_de_platos,
                });
                opciones_de_platos = [];
            }
        }
    });
    $("#exampleModalCenter").modal("hide");
    addPlateOptionsWithPlate();
    checkIfShowSaveTemplate();
}

function checkIfShowSaveTemplate() {
    if (listResultsPlates.children().length > 0) {
        btn_save_template.removeClass("d-none");
    } else {
        btn_save_template.addClass("d-none");
    }
}

function editarPlato(pregunta) {
    if (input_add_question.val() !== "" || listBadges.children().length > 0) {
        SwalShowMessage(
            "warning",
            "¡Advertencia!",
            "Debe agregar el plato actual antes de editar otro"
        );
        return;
    }

    let plato = platos_with_options.find((plato) =>
        plato.hasOwnProperty(pregunta)
    );
    let opciones = plato[pregunta];
    input_add_question.val(pregunta);
    opciones.forEach((opcion) => {
        let badge = $(
            "<a href='javascript:void(0)' class='badge badge-rounded badge-primary' onclick='editarOpcion(event)' ondblclick='eliminarOpcion(event)'></a>"
        );
        badge.text(opcion);
        badge.appendTo(listBadges);
        opciones_de_platos.push(opcion);
    });
    platos_with_options.splice(
        platos_with_options.findIndex((plato) =>
            plato.hasOwnProperty(pregunta)
        ),
        1
    );
    addPlateOptionsWithPlate();
    checkIfShowSaveTemplate();
}

// para eliminar una opcion de un plato
function eliminarOpcion(e) {
    Swal.fire({
        title: "¿Estás seguro de eliminar la opción del grupo de platos?",
        text: "¡No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "¡Sí, bórralo!",
        cancelButtonText: "No, cancelar",
        confirmButtonColor: "#fc410c",
        cancelButtonColor: "#3085d6",
    }).then((result) => {
        if (result.value) {
            let index = $(e.target).index();
            $(e.target).remove();
            opciones_de_platos.splice(index, 1);
            SwalShowMessage(
                "success",
                "¡Éxito!",
                "Se ha eliminado la opción correctamente, no olvide agregar el grupo de platos al menú"
            );
        }
    });
}

function editarOpcion(e) {
    const tipo_menu = select_tipoMenu.val();
    if (
        tipo_menu == "Menu a Elegir con Precio" &&
        input_add_option.val() == ""
    ) {
        let index = $(e.target).index();
        let opcion = opciones_de_platos[index];
        let precio = opcion.split(" - ")[1];
        let option = opcion.split(" - ")[0];
        input_add_option.val(option);
        maskInputPrice.value = precio;
        opciones_de_platos.splice(index, 1);
        $(e.target).remove();
    }

    if (
        tipo_menu == "Menu a Elegir sin Precio" &&
        input_add_option.val() == ""
    ) {
        let index = $(e.target).index();
        let opcion = opciones_de_platos[index];
        input_add_option.val(opcion);
        opciones_de_platos.splice(index, 1);
        $(e.target).remove();
    }
}

for (let i = 1; i <= 30; i++) {
    array_name_platos.push(`${i}º`);
}

function limpiarVariablesYCampos() {
    // limpiar los platos con opciones
    platos_with_options = [];
    // limpiar las opciones de los platos
    opciones_de_platos = [];
    // limpiar los badges
    listBadges.empty();
    // limpiar el input de pregunta
    input_add_question.val("");
    // limpiar el input de opciones
    input_add_option.val("");
    // limpiar el input de precio
    maskInputPrice.value = "";
    // limpiar el input de nombre de plantilla
    $("#nombrePlantilla").val("");
    // limpiar el input de nombre de plantilla
    listResultsPlates.html("");
    // llenar el input de tipo de menu
    select_tipoMenu.val("Menu a Elegir con Precio");
    // llenar el input de nombre de plantilla
    actualPlato.text(array_name_platos[platos_with_options.length]);
    addPlateOptionsWithPlate();
    checkIfShowSaveTemplate();
}

function showLoader() {
    $("#loader_page").show();
}
function hideLoader() {
    $("#loader_page").hide();
}

/* ------------------------------------------ SORTEBALE ----------------------------------------- */
const sorteblaeListPlates = document.getElementById("listResultsPlates");
const sortable = Sortable.create(sorteblaeListPlates, {
    sort: true,
    animation: 150,
    onChange: function (/**Event*/ evt) {
        const nuevaPosicion = evt.newIndex;
        const viejaPosicion = evt.oldIndex;
        // cambiar el orden de los platos
        let plato = platos_with_options[viejaPosicion];
        platos_with_options.splice(viejaPosicion, 1);
        platos_with_options.splice(nuevaPosicion, 0, plato);
    },
});

const sorteableListOptions = document.getElementById("listBadges");
const sortableOptions = Sortable.create(sorteableListOptions, {
    sort: true,
    animation: 150,
    onEnd: function (/**Event*/ evt) {
        const nuevaPosicion = evt.newIndex;
        const viejaPosicion = evt.oldIndex;
        // cambiar el orden de los platos
        let opcion = opciones_de_platos[viejaPosicion];
        opciones_de_platos.splice(viejaPosicion, 1);
        opciones_de_platos.splice(nuevaPosicion, 0, opcion);
    },
});
