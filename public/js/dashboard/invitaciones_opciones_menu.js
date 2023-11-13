let input_add_option = $("#input_add_option");
let btn_add_option = $("#btn_add_option");
let btn_add_other_plate = $("#btn_add_other_plate");
let listBadges = $("#listBadges");
let listResultsPlates = $("#listResultsPlates");
let actualPlato = $("#actualPlato");
let array_name_platos = [];
let opciones_de_platos = [];
let platos_with_options = []; // variable que guarda el resultado final de los platos con sus opciones

/* ------------------------------------------- EVENTOS ------------------------------------------ */

// para agregar una opcion a un plato
btn_add_option.click(function () {
    let option = input_add_option.val();

    if (option !== "") {
        let badge = $(
            "<a href='javascript:void(0)' class='badge badge-rounded badge-primary' onclick='eliminarOpcion(event)'></a>"
        );
        badge.text(option);
        badge.appendTo(listBadges);
        opciones_de_platos.push(option);
        input_add_option.val("");
        input_add_option.focus();
    }
});

input_add_option.keyup(function (e) {
    if (e.keyCode === 13) {
        btn_add_option.click();
    }
});
// para agregar un plato a la lista de platos
btn_add_other_plate.click(function () {
    let list_badges_has_child = listBadges.children().length;
    if (list_badges_has_child >= 2) {
        platos_with_options.push(opciones_de_platos);
        opciones_de_platos = [];
        listBadges.empty();
        input_add_option.val("");
        actualPlato.text(array_name_platos[platos_with_options.length]);
        input_add_option.focus();
        addPlateOptionsWithPlate();
    }
});

/* ------------------------------------------ FUNCIONES ----------------------------------------- */

// para agregar los platos a la lista de platos ya aramados
function addPlateOptionsWithPlate() {
    let html = "";
    platos_with_options.forEach((element, index) => {
        let badgesOptions = "";

        element.forEach((option) => {
            badgesOptions += `<a href="javascript:void(0)" class="badge badge-rounded badge-primary">${option}</a>`;
        });

        html += `
        <div class="mt-3">
            <h4 class="d-flex gap-2">
                <div class="border border-primary rounded-circle"
                    style="width: 22px; height: 22px;"></div> ${array_name_platos[index]} plato a elegir
            </h4>
            <div class="bootstrap-badge mb-3 mt-1">
                ${badgesOptions}
            </div>
        </div>
        `;
    });

    listResultsPlates.html(html);
}

// para eliminar una opcion de un plato
function eliminarOpcion(e) {
    let index = $(e.target).index();
    $(e.target).remove();
    opciones_de_platos.splice(index, 1);
}

for (let i = 1; i <= 30; i++) {
    array_name_platos.push(`${i}º`);
}
