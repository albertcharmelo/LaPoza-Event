const btnActualizarPlatos = document.getElementById("btnActualizarPlatos");

function selectPlato(e) {
    // marcar el input checkbox hijo con clase opcion_plato
    $(e.target).children(".opcion_plato").prop("checked", true);
}

function selectPlatoH4(e) {
    // marcar el input checkbox hermano con clase opcion_plato
    $(e.target).siblings(".opcion_plato").prop("checked", true);
}

const verificarPlatos = () => {
    const respuestas = [];

    $(".opcion_plato:checked").each(function () {
        const platoQuestion = $(this)
            .closest(".opcion_plato_box")
            .siblings(".plato_question")
            .text();
        const opcionSeleccionada = $(this).val();

        respuestas.push({
            [platoQuestion]: opcionSeleccionada,
        });
    });

    if (respuestas.length !== $(".platos_select").length) {
        SwalShowMessage(
            "warning",
            "¡Advertencia!",
            "Debe seleccionar una opción para cada plato"
        );
        return;
    }

    return respuestas;
};

btnActualizarPlatos.addEventListener("click", async (e) => {
    actualizarPlatos();
});

const actualizarPlatos = async () => {
    const respuestas = verificarPlatos();
    if (!respuestas) return;

    const idInvitado = $("#idInvitado").val();

    const data = {
        idInvitado,
        respuestas,
    };

    console.log(data);

    // const url = `${window.location.origin}/invitado/editarPlato`;
    // const options = {
    //     method: "POST",
    //     body: JSON.stringify(data),
    //     headers: {
    //         "Content-Type": "application/json",
    //     },
    // };

    // const res = await fetch(url, options);
    // const { status } = res;

    // if (status === 200) {
    //     SwalShowMessage(
    //         "success",
    //         "¡Éxito!",
    //         "Se han actualizado los platos del invitado"
    //     );
    // } else {
    //     SwalShowMessage(
    //         "error",
    //         "¡Error!",
    //         "Ha ocurrido un error al actualizar los platos del invitado"
    //     );
    // }
};

$(document).ready(function () {
    jQuery(".owl-carousel").owlCarousel({
        loop: true,
        autoplay: true,
        margin: 20,
        nav: true,
        rtl: true,
        dots: true,
        responsive: {
            0: {
                items: 1,
            },
            450: {
                items: 1,
            },
            600: {
                items: 1,
            },
            991: {
                items: 1,
            },

            1200: {
                items: 1,
            },
            1601: {
                items: 1,
            },
        },
    });
});
