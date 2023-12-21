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

    const url = `/invitados/editarPlato`;
    const options = {
        method: "PUT",
        body: JSON.stringify({
            invitado_id: idInvitado,
            platos_elegidos: respuestas,
        }),
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    };

    const res = await fetch(url, options);
    const { status } = res;

    if (status === 200) {
        window.location.href = `/qrcode/invitacion/${idInvitado}`;
    } else {
        console.log("error");
    }
};
