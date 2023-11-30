let btnGuardar = $("#btnGuardar");
let titulo = $("#titulo");
let files = $("#files");
let ckeditorInvitacion = $("#ckeditorInvitacion");
let listDocumentos = $("#listDocumentos");
let tipoMenu = $("#tipoMenu");
let boxUploadMenu = $("#boxUploadMenu");
let boxUploadOptions = $("#boxUploadOptions");
let inputPrice = $("#input_add_price");
let arrayImagenesFiles = [];
let filesArray = [];
let nombre_org = $("#nombre_org");
let email_org = $("#email_org");
let telefono_organizador = document.getElementById("telefono_org");
let fecha_evento = $("#fecha_evento");
let btn_crear = $("#btn_crear");
let btn_index = $("#btn_index");

const maskInputOptions = {
    mask: "000-00-00-00",
};
const telefono_org = IMask(telefono_organizador, maskInputOptions);

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

                if (arrayImagenesFiles.length == 0) {
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
                    if (
                        document.querySelector("#input_file_menu").files[0] ==
                        ""
                    ) {
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
                            confirmButtonColor: "#fc410c",
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
    btn_crear.hide();
    btn_index.show();
});

function iniciarDatos() {
    titulo.val("");
    CKeditor.setData("");
    files.val("");
    listDocumentos.text("");
    tipoMenu.val("");
    input_file_menu.value = "";
    name_menu_uploaded.innerHTML = "";
    boxUploadMenu.hide();
    boxUploadOptions.hide();
    arrayImagenesFiles = [];
    filesArray = [];
    platos_with_options = [];
    listResultsPlates.html("");
    actualPlato.text("1º");

    nombre_org.val("");
    email_org.val("");
    telefono_org.value = "";
    let fecha = new Date();
    let dia = fecha.getDate();
    let mes = fecha.getMonth() + 1;
    let anio = fecha.getFullYear();
    fecha_evento.val(anio + "-" + mes + "-" + dia);

    if (invitacion_edit != null) {
        titulo.val(invitacion_edit.titulo);
        CKeditor.setData(invitacion_edit.texto);

        invitacion_edit.imagenes.forEach(function (imagen) {
            arrayImagenesFiles.push(imagen);
        });
        mostrarDocumentos();

        tipoMenu.val(invitacion_edit.tipo_menu);
        if (
            tipoMenu.val() == "Menu Fijo con Precio" ||
            tipoMenu.val() == "Menu Fijo sin Precio"
        ) {
            boxUploadMenu.show();
            input_file_menu.value = "";
            document.querySelector("#input_file_menu").files[0] =
                invitacion_edit.imagen;
            document.getElementById(
                "name_menu_uploaded"
            ).innerHTML = `<br><span class="badge badge-pill badge-primary">${invitacion_edit.imagen_nombre}</span>`;
        } else {
            if (tipoMenu.val() == "Menu a Elegir con Precio") {
                inputPrice.show();
            } else {
                inputPrice.hide();
            }
            boxUploadOptions.show("slow");

            platos_with_options = invitacion_edit.platos_opciones;
            addPlateOptionsWithPlate();
        }

        nombre_org.val(invitacion_edit.evento.nombre);
        email_org.val(invitacion_edit.evento.email_organizador);
        telefono_org.value = invitacion_edit.evento.telefono_organizador;
        let fecha = new Date(invitacion_edit.evento.fecha);
        let dia = fecha.getDate();
        let mes = fecha.getMonth() + 1;
        let anio = fecha.getFullYear();
        fecha_evento.val(anio + "-" + mes + "-" + dia);
    }
}

function mostrarDocumentos() {
    listDocumentos.html("");
    for (let i = 0; i < arrayImagenesFiles.length; i++) {
        let fileContainer = $('<div class="file-container"></div>');
        let fileName = $('<span class="file-name"></span>').text(
            arrayImagenesFiles[i].nombre
        );
        let deleteButton = $(
            `<button class="delete-button" onclick="eliminarDocumento('${arrayImagenesFiles[i].id}','${i}')">x</button>`
        );
        fileContainer.append(fileName);
        fileContainer.append(deleteButton);
        $("#listDocumentos").append(fileContainer);
    }
}

function eliminarDocumento(imagen_id, i) {
    const URL = "/invitaciones/eliminarDocumento";
    try {
        showLoader();
        fetch(URL, {
            method: "POST",
            body: JSON.stringify({
                imagen_id: imagen_id,
                invitacion_id: invitacion_edit.id,
            }),
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": _token,
            },
        })
            .then((response) => {
                if (!response.ok) {
                    SwalShowMessage(
                        "warning",
                        "¡Advertencia!",
                        "No se pudo eliminar el archivo"
                    );
                }
                return response.json();
            })
            .then((data) => {
                if (data.status == "success") {
                    SwalShowMessage(
                        "success",
                        "¡Éxito!",
                        "Se eliminó el archivo correctamente"
                    );
                    for (let i = 0; i < arrayImagenesFiles.length; i++) {
                        if (arrayImagenesFiles[i].id == imagen_id) {
                            arrayImagenesFiles.splice(i, 1);
                        }
                    }
                    for (let i = 0; i < filesArray.length; i++) {
                        if (filesArray[i].name == data.documento.nombre) {
                            filesArray.splice(i, 1);
                        }
                    }
                    mostrarDocumentos();
                }
            });
    } catch (error) {
        SwalShowMessage(
            "warning",
            "¡Advertencia!",
            "No se pudo eliminar el archivo"
        );
    } finally {
        hideLoader();
    }
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

    if (arrayImagenesFiles.length == 0) {
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
        if (document.querySelector("#input_file_menu").files[0] == "") {
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
                confirmButtonColor: "#fc410c",
                allowOutsideClick: false,
            }).then((result) => {
                if (result.value) {
                    input_add_option.focus();
                }
            });
            return false;
        }
        platos_opciones_obj = platos_with_options;
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
        data.append("file_menu[nombre]", file.name);
    }

    agregarInvitacion();

    async function agregarInvitacion() {
        const data = new FormData();
        data.append("titulo", titulo.val());
        data.append("descripcion", CKeditor.getData());
        data.append("tipoMenu", tipoMenu.val());
        data.append("platos_opciones", JSON.stringify(platos_opciones_obj));

        if (invitacion_edit == null) {
            const fileMenu =
                document.querySelector("#input_file_menu").files[0];
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
        }

        data.append("nombre_org", nombre_org.val());
        data.append("email_org", email_org.val());
        data.append("telefono_org", telefono_org.value);
        data.append("fecha_evento", fecha_evento.val());

        let URL = "/invitaciones/agregarInvitacion";
        if (invitacion_edit != null) {
            URL = "/invitaciones/actualizarInvitacion";
            data.append("invitacion_id", invitacion_edit.id);
        }
        try {
            showLoader();
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
                    invitacion_edit = null;
                    iniciarDatos();
                    $("#smartwizard").smartWizard("goToStep", 0);
                    if (data.status == "success") {
                        Swal.fire({
                            type: "success",
                            title: "¡Éxito!",
                            text: data.message,
                            confirmButtonText: "Aceptar",
                            confirmButtonColor: "#fc410c",
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = "/invitaciones/index";
                            }
                        });
                    }
                });
        } catch (error) {
            SwalShowMessage(
                "warning",
                "¡Advertencia!",
                "No se pudo agregar la invitación"
            );
        } finally {
            hideLoader();
        }
    }
});

function getBase64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = (error) => reject(error);
    });
}

function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

document.querySelector("#files").addEventListener("change", function (e) {
    var fileName = "";    
    for (let i = 0; i < this.files.length; i++) {
        fileName = this.files[i].name;        
        if (
            arrayImagenesFiles.filter((imagen) => imagen.nombre == fileName)
                .length == 0
        ) {
            filesArray.push(this.files[i]);
            if (invitacion_edit == null) {
                arrayImagenesFiles.push({
                    nombre: fileName,
                });
            }
        } else {
            SwalShowMessage(
                "warning",
                "¡Advertencia!",
                "El archivo " + fileName + " ya ha sido seleccionado."
            );
            return false;
        }
    }

    if (invitacion_edit == null) {
        listDocumentos.html("");        
        for (let i = 0; i < arrayImagenesFiles.length; i++) {
            let fileContainer = $('<div class="file-container"></div>');
            let fileName = $('<span class="file-name"></span>').text(
                arrayImagenesFiles[i].nombre
            );
            let deleteButton = $('<button class="delete-button">x</button>');
            deleteButton.on("click", function () {
                arrayImagenesFiles.splice(i, 1);
                fileContainer.remove();
                for (let j = 0; j < filesArray.length; j++) {
                    if (filesArray[j].name == arrayImagenesFiles[i].nombre) {
                        filesArray.splice(j, 1);
                    }
                }
            });

            fileContainer.append(fileName);
            fileContainer.append(deleteButton);
            $("#listDocumentos").append(fileContainer);
        }
    } else {
        agregarDocumento();
        async function agregarDocumento() {
            let data = new FormData();
            data.append("invitacion_id", invitacion_edit.id);
            let documento = document.querySelector("#files").files[0];
            data = await appendDocumentoToFormData(documento, data);

            const URL = "/invitaciones/agregarDocumento";
            try {
                showLoader();
                fetch(URL, {
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
                                "No se pudo agregar el documento"
                            );
                        }
                        return response.json();
                    })
                    .then((data) => {
                        if (data.status == "success") {
                            SwalShowMessage(
                                "success",
                                "¡Éxito!",
                                "documento agregado correctamente"
                            );
                            arrayImagenesFiles.push(data.imagen);
                            mostrarDocumentos();
                        }
                    });
            } catch (error) {
                SwalShowMessage(
                    "warning",
                    "¡Advertencia!",
                    "No se pudo agregar el documento"
                );
            } finally {
                hideLoader();
            }
        }
    }
});

async function appendDocumentoToFormData(documento, data) {
    const base64File = await getBase64(documento);
    data.append("documento[base64]", base64File);
    data.append("documento[name]", documento.name);
    data.append("documento[type]", documento.type);
    data.append("documento[size]", documento.size.toString());
    return data;
}

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
        if (tipoMenu.val() == "Menu a Elegir con Precio") {
            inputPrice.show();
        } else {
            inputPrice.hide();
        }

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

    if (invitacion_edit != null) {
        actualizarImagenMenu();
        async function actualizarImagenMenu() {
            let data = new FormData();
            data.append("invitacion_id", invitacion_edit.id);
            let documento = document.querySelector("#input_file_menu").files[0];
            data = await appendDocumentoToFormData(documento, data);

            const URL = "/invitaciones/updateImagenMenu";
            try {
                showLoader();
                fetch(URL, {
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
                                "No se pudo actualizar la imagen del menú"
                            );
                        }
                        return response.json();
                    })
                    .then((data) => {
                        if (data.status == "success") {
                            SwalShowMessage(
                                "success",
                                "¡Éxito!",
                                "Imagen del menú actualizada correctamente"
                            );
                        }
                    });
            } catch (error) {
                SwalShowMessage(
                    "warning",
                    "¡Advertencia!",
                    "No se pudo actualizar la imagen del menú"
                );
            } finally {
                hideLoader();
            }
        }
    }
}

function showLoader() {
    $("#loader_page").show();
}
function hideLoader() {
    $("#loader_page").hide();
}
