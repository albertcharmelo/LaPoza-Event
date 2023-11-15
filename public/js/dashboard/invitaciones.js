let btnGuardar = $("#btnGuardar");
let titulo = $("#titulo");
let files = $("#files");
let ckeditorInvitacion = $("#ckeditorInvitacion");
let listoDocumentos = $("#listoDocumentos");
let tipoMenu = $("#tipoMenu");
let boxUploadMenu = $("#boxUploadMenu");
let boxUploadOptions = $("#boxUploadOptions");
let arrayFiles = [];
let filesArray = [];
let nombre_org = $("#nombre_org");
let email_org = $("#email_org");
let telefono_org = $("#telefono_org");
let fecha_evento = $("#fecha_evento");

$(document).ready(function () {
    // SmartWizard initialize
    var smartWizard = $("#smartwizard").smartWizard();

    // Go to step 1
    smartWizard.smartWizard("goToStep", 0);

    smartWizard.on(
        "leaveStep",
        function (e, anchorObject, stepNumber, stepDirection) {
            if (stepNumber === 0) {
                if (titulo.val() == "") {
                    SwalShowMessage(
                        "warning",
                        "¡Advertencia!",
                        "Debe ingresar un título"
                    );
                    return false;
                }

                if (CKeditor.getData() == "") {
                    SwalShowMessage(
                        "warning",
                        "¡Advertencia!",
                        "Debe ingresar un mensaje de invitación"
                    );
                    return false;
                }

                if (files.val() == "") {
                    SwalShowMessage(
                        "warning",
                        "¡Advertencia!",
                        "Debe seleccionar al menos un archivo"
                    );
                    return false;
                }
            }
            if (stepNumber === 1) {
                if (tipoMenu.val() == null) {
                    SwalShowMessage(
                        "warning",
                        "¡Advertencia!",
                        "Debe seleccionar un tipo de menú"
                    );
                    return false;
                }

                if (
                    tipoMenu.val() == "Menu Fijo con Precio" ||
                    tipoMenu.val() == "Menu Fijo sin Precio"
                ) {
                    if (input_file_menu.value == "") {
                        SwalShowMessage(
                            "warning",
                            "¡Advertencia!",
                            "Debe seleccionar un archivo de menú"
                        );
                        return false;
                    }
                }

                if (
                    tipoMenu.val() == "Menu a Elegir con Precio" ||
                    tipoMenu.val() == "Menu a Elegir sin Precio"
                ) {
                    if (platos_with_options.length == 0) {
                        Swal.fire({
                            type: "warning",
                            title: "¡Advertencia!",
                            text: "Debe agregar los platos con sus opciones",
                            confirmButtonText: "Aceptar",
                            confirmButtonColor: "#3085d6",
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.value) {
                                input_add_option.focus();
                            }
                        });
                        return false;
                    }
                }
            }
        }
    );
    iniciarDatos();
});

function iniciarDatos() {
    titulo.val("");
    CKeditor.setData("");
    files.val("");
    listoDocumentos.text("");
    tipoMenu.val("");
    input_file_menu.value = "";
    name_menu_uploaded.innerHTML = "";
    boxUploadMenu.hide();
    boxUploadOptions.hide();
    arrayFiles = [];
    filesArray = [];
    boxUploadOptions.hide();
    platos_with_options = [];
    listResultsPlates.html("");
    actualPlato.text("1º");

    nombre_org.val("");
    email_org.val("");
    telefono_org.val("");
    let fecha = new Date();
    let dia = fecha.getDate();
    let mes = fecha.getMonth() + 1;
    let anio = fecha.getFullYear();
    fecha_evento.val(anio + "-" + mes + "-" + dia);
}

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

btnGuardar.on("click", function () {
    if (titulo.val() == "") {
        SwalShowMessage("warning", "¡Advertencia!", "Debe ingresar un título");
        return false;
    }

    if (CKeditor.getData() == "") {
        SwalShowMessage(
            "warning",
            "¡Advertencia!",
            "Debe ingresar un mensaje de invitación"
        );
        return false;
    }

    if (files.val() == "") {
        SwalShowMessage(
            "warning",
            "¡Advertencia!",
            "Debe seleccionar al menos un archivo"
        );
        return false;
    }

    if (tipoMenu.val() == null) {
        SwalShowMessage(
            "warning",
            "¡Advertencia!",
            "Debe seleccionar un tipo de menú"
        );
        return false;
    }

    if (
        tipoMenu.val() == "Menu Fijo con Precio" ||
        tipoMenu.val() == "Menu Fijo sin Precio"
    ) {
        if (input_file_menu.value == "") {
            SwalShowMessage(
                "warning",
                "¡Advertencia!",
                "Debe seleccionar un archivo de menú"
            );
            return false;
        }
    }

    let platos_opciones_obj = "";
    if (
        tipoMenu.val() == "Menu a Elegir con Precio" ||
        tipoMenu.val() == "Menu a Elegir sin Precio"
    ) {
        if (platos_with_options.length == 0) {
            Swal.fire({
                type: "warning",
                title: "¡Advertencia!",
                text: "Debe agregar los platos con sus opciones",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#3085d6",
                allowOutsideClick: false,
            }).then((result) => {
                if (result.value) {
                    input_add_option.focus();
                }
            });
            return false;
        }
        platos_opciones_obj = platos_with_options.map((plato, index) => {
            let obj = {};
            plato.forEach((value, i) => {
                obj[`${i + 1}`] = value;
            });
            return obj;
        });
    }

    if (nombre_org.val() == "") {
        SwalShowMessage(
            "warning",
            "¡Advertencia!",
            "Debe ingresar el nombre de organizador"
        );
        return false;
    }

    if (email_org.val() == "") {
        SwalShowMessage(
            "warning",
            "¡Advertencia!",
            "Debe ingresar el email de organizador"
        );
        return false;
    } else {
        if (!validateEmail(email_org.val())) {
            SwalShowMessage(
                "warning",
                "¡Advertencia!",
                "Debe ingresar un email válido"
            );
            return false;
        }
    }

    async function appendFileToFormData(file, data) {
        const base64File = await getBase64(file);
        data.append("file_menu[base64]", base64File);
    }

    function getBase64(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = (error) => reject(error);
        });
    }

    agregarInvitacion();
    async function agregarInvitacion() {
        const data = new FormData();
        data.append("titulo", titulo.val());
        data.append("descripcion", CKeditor.getData());
        data.append("tipoMenu", tipoMenu.val());
        data.append("platos_opciones", JSON.stringify(platos_opciones_obj));
        // filesArray.forEach((file, index) => {
        //     data.append(`files[${index}]`, file);
        // });

        const fileMenu = document.querySelector("#input_file_menu").files[0];
        appendFileToFormData(fileMenu, data);

        const filePromises = filesArray.map((file, index) => {
            return getBase64(file).then((base64File) => {
                data.append(`files[${index}][base64]`, base64File);
                data.append(`files[${index}][name]`, file.name);
                data.append(`files[${index}][type]`, file.type);
                data.append(`files[${index}][size]`, file.size.toString());
            });
        });
        await Promise.all(filePromises);

        data.append("nombre_org", nombre_org.val());
        data.append("email_org", email_org.val());
        data.append("telefono_org", telefono_org.val());
        data.append("fecha_evento", fecha_evento.val());

        const URL = "/invitaciones/agregarInvitacion";
        try {
            // showLoader();
            await fetch(URL, {
                method: "POST",
                body: data,
                headers: {
                    "X-CSRF-TOKEN": _token,
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        SwalShowMessage(
                            "warning",
                            "¡Advertencia!",
                            "No se pudo agregar la invitación"
                        );
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.status == "success") {
                        SwalShowMessage("success", "¡Éxito!", data.message);
                    }
                    iniciarDatos();
                    $("#smartwizard").smartWizard("goToStep", 0);
                });
        } catch (error) {
            SwalShowMessage(
                "warning",
                "¡Advertencia!",
                "No se pudo agregar la invitación"
            );
        } finally {
            // hideLoader();
        }
    }
});

function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

document.querySelector("#files").addEventListener("change", function (e) {
    var fileName = "";
    for (let i = 0; i < this.files.length; i++) {
        fileName += this.files[i].name + ", ";
        filesArray.push(this.files[i]);
    }
    fileName = fileName.slice(0, -2);
    arrayFiles.push(fileName);
    listoDocumentos.html("");
    for (let i = 0; i < arrayFiles.length; i++) {
        listoDocumentos.append(arrayFiles[i] + ", ");
    }
    let text = listoDocumentos.text();
    text = text.slice(0, -2);
    listoDocumentos.text(text);
    if (listoDocumentos.text() != "") {
        listoDocumentos.show();
    } else {
        listoDocumentos.hide();
    }
});

tipoMenu.on("change", function () {
    name_menu_uploaded.innerHTML = "";
    platos_with_options = [];
    listResultsPlates.html("");
    input_file_menu.value = "";
    opciones_de_platos = [];

    if (
        tipoMenu.val() == "Menu Fijo con Precio" ||
        tipoMenu.val() == "Menu Fijo sin Precio"
    ) {
        boxUploadMenu.show("slow");
    } else {
        boxUploadMenu.hide("fast");
    }
    if (
        tipoMenu.val() == "Menu a Elegir con Precio" ||
        tipoMenu.val() == "Menu a Elegir sin Precio"
    ) {
        actualPlato.text("1º");
        input_add_option.val("");
        listBadges.html("");
        boxUploadOptions.show("slow");
        input_add_option.focus();
    } else {
        boxUploadOptions.hide("fast");
    }
});

document
    .getElementById("input_file_menu")
    .addEventListener("change", ShowNameMenuUploaded, false);

function openInputMenu() {
    document.getElementById("input_file_menu").click();
}

function ShowNameMenuUploaded(e) {
    var fileName = "";
    for (var i = 0; i < e.srcElement.files.length; i++) {
        fileName +=
            '<br><span class="badge badge-pill badge-primary">' +
            e.srcElement.files[i].name +
            "</span>";
    }
    document.getElementById("name_menu_uploaded").innerHTML = fileName;
}
