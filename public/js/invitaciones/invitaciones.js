const postBox = $("#postBox");
const platosBox = $("#platosBox");
const datosBox = $("#datosBox");
const datosFormulario = $("#datosFormulario");
const QrCodeBox = $("#QrCodeBox");
const qrImageBase64 = $("#qrImageBase64"); // img tag
const urlToSeeQr = $("#urlToSeeQr"); // a tag
const BtnNext = $("#BtnNext");
let telefono = document.getElementById("telefono");
let patos_seleccionados = [];
let currentStep = 1;

const maskInputOptions = {
    mask: "000-00-00-00",
};
const telefono_invi = IMask(telefono, maskInputOptions);

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

/**
 * Muestra el código QR de una invitación.
 * @param {Object} data - Los datos de la invitación.
 */
function mostrarQrCode(data) {
    const src = `data:image/png;base64,${data.codigoQr.path}`;
    const url = `/qrcode/invitacion/${data.id}`;
    qrImageBase64.attr("src", src);
    urlToSeeQr.attr("href", url);
    urlToSeeQr.text(new URL(url, window.location.origin).href);
}

/**
 * Verifica si se han seleccionado opciones para cada plato y devuelve un array con las respuestas.
 * @returns {Array} - Array con las respuestas seleccionadas para cada plato.
 */
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

/**
 * Función asíncrona que envía la información del formulario a través de una petición POST.
 * @param {Event} e - Evento del formulario.
 * @returns {Promise<void>}
 */
const enviarInforamcion = async (e) => {
    e.preventDefault();
    let data = Object.fromEntries(new FormData(e.target));

    // verificar que no existan campos vacios
    const { nombre, telefono, invitados } = data;
    if (!nombre || !telefono || !invitados) {
        SwalShowMessage(
            "warning",
            "¡Advertencia!",
            "Debe llenar los campos de nombre, teléfono y numero invitados"
        );
        return;
    }

    data.platos = verificarPlatos();
    console.log(data);
    BtnNext.prop("disabled", true);
    BtnNext.innerHTML = `<div class='d-flex gap-2'>
                <div class="spinner-border text-dark" role="status">
            <span class="sr-only">Loading...</span>
            </div>
            <span>Enviando...</span>
    </div>`;

    try {
        const response = await axios.post("/invitados/create", data, {
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        if (response.status === 200) {
            const dataResponse = response.data;
            BtnNext.innerHTML = "Enviar";
            BtnNext.prop("disabled", false);
            BtnNext.hide("fast");
            await datosBox.hide("fast");
            mostrarQrCode(dataResponse);
            await QrCodeBox.show("slow");
            currentStep++;
        }
    } catch (error) {
        SwalShowMessage("error", "¡Error!", error);
        BtnNext.innerHTML = "Enviar";
        BtnNext.prop("disabled", false);
    }
};

/**
 * Función asíncrona que maneja el siguiente paso del proceso de invitaciones.
 * @returns {Promise<void>}
 */
const nextStep = async () => {
    switch (currentStep) {
        case 1:
            await postBox.hide("fast");
            await platosBox.show("slow");
            currentStep++;
            BtnNext.text("Acepto");

            break;
        case 2:
            const platos = verificarPlatos();
            if (platos !== undefined) {
                await platosBox.hide("fast");
                await datosBox.show("slow");
                currentStep++;
                BtnNext.text("Enviar");
            }
            break;
        case 3:
            datosFormulario.submit();
            break;
        default:
            break;
    }
};

function selectPlato(e) {
    // marcar el input checkbox hijo con clase opcion_plato
    $(e.target).children(".opcion_plato").prop("checked", true);
}

BtnNext.on("click", nextStep);
datosFormulario.on("submit", (e) => {
    e.preventDefault();
    enviarInforamcion(e);
});
