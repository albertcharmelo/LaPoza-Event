let btnGuardar = $("#btnGuardar");
let titulo = $("#titulo");
let files = $("#files");
let descripcion = $("#descripcion");
let listoDocumentos = $("#listoDocumentos");
let tipoMenu = $("#tipoMenu");
let boxUploadMenu = $("#boxUploadMenu");
let boxUploadOptions = $("#boxUploadOptions");
let arrayFiles = [];
let filesArray = [];
document.addEventListener("DOMContentLoaded", function () {});

btnGuardar.on("click", function () {
    agregarInvitacion();
    if (titulo.val() == "") {
        Swal.fire({
            type: "warning",
            title: "¡Advertencia!",
            text: "Debe ingresar un título",
            confirmButtonText: "Aceptar",
            confirmButtonColor: "#3085d6",
            allowOutsideClick: false,
        });
        return false;
    }

    if (descripcion.val() == "") {
        Swal.fire({
            type: "warning",
            title: "¡Advertencia!",
            text: "Debe ingresar una descripción",
            confirmButtonText: "Aceptar",
            confirmButtonColor: "#3085d6",
            allowOutsideClick: false,
        });
        return false;
    }

    async function agregarInvitacion() {
        const data = new FormData();
        data.append("titulo", titulo.val());
        data.append("descripcion", descripcion.val());
        data.append("tipoMenu", tipoMenu.val());
        filesArray.forEach((file, index) => {
            data.append(`files[${index}]`, file);
        });

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
                        Swal.fire({
                            type: "warning",
                            title: "¡Advertencia!",
                            text: "No se pudo agregar la invitación",
                            confirmButtonText: "Aceptar",
                            confirmButtonColor: "#3085d6",
                            allowOutsideClick: false,
                        });
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.status == "success") {
                        Swal.fire({
                            type: "success",
                            title: "¡Éxito!",
                            text: data.message,
                            confirmButtonText: "Aceptar",
                            confirmButtonColor: "#3085d6",
                            allowOutsideClick: false,
                        });
                    }
                });
        } catch (error) {
            Swal.fire({
                type: "warning",
                title: "¡Advertencia!",
                text: "No se pudo agregar la invitación",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#3085d6",
                allowOutsideClick: false,
            });
        } finally {
            // hideLoader();
        }
    }
});

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
    if (
        tipoMenu.val() == "Menu Fijo con Precio" ||
        tipoMenu.val() == "Menu Fijo sin Precio"
    ) {
        boxUploadMenu.show("slow");
    } else {
        boxUploadMenu.hide("fast");
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
