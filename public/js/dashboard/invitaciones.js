let btnGuardar = $("#btnGuardar");
let titulo = $("#titulo");
let files = $("#files");
let descripcion = $("#descripcion");
let ckeditorInvitacion = $("#ckeditorInvitacion");
let listoDocumentos = $("#listoDocumentos");
let tipoMenu = $("#tipoMenu");
let boxUploadMenu = $("#boxUploadMenu");
let boxUploadOptions = $("#boxUploadOptions");
let arrayFiles = [];
let filesArray = [];

$(document).ready(function () {
    // SmartWizard initialize
    var smartWizard = $("#smartwizard").smartWizard();

    // Go to step 1
    smartWizard.smartWizard("goToStep", 0);

    smartWizard.on(
        "leaveStep",
        function (e, anchorObject, stepNumber, stepDirection) {
            console.log(stepNumber, stepDirection);
            if (stepNumber === 0) {
                console.log("titulo: " + titulo.val());
                console.log("titulo: ", titulo.val());                
                if (titulo.val() == "") {
                    Swal.fire({
                        type: "warning",
                        title: "¡Advertencia!",
                        text: "Debe ingresar un título",
                        confirmButtonText: "Aceptar",
                        confirmButtonColor: "#3085d6",
                        allowOutsideClick: false,
                    });
                }

                if (CKeditor.getData() == "") {
                    Swal.fire({
                        type: "warning",
                        title: "¡Advertencia!",
                        text: "Debe ingresar un mensaje de invitación",
                        confirmButtonText: "Aceptar",
                        confirmButtonColor: "#3085d6",
                        allowOutsideClick: false,
                    });
                    return false;
                }

                if (files.val() == "") {
                    Swal.fire({
                        type: "warning",
                        title: "¡Advertencia!",
                        text: "Debe seleccionar al menos un archivo",
                        confirmButtonText: "Aceptar",
                        confirmButtonColor: "#3085d6",
                        allowOutsideClick: false,
                    });
                    return false;
                }
            }

            // if (stepNumber === 1) {
            //     if (
            //         tipoMenu.val() == "Menu a Elegir con Precio" ||
            //         tipoMenu.val() == "Menu a Elegir sin Precio"
            //     ) {
            //         if (boxUploadOptions.val() == "") {
            //             Swal.fire({
            //                 type: "warning",
            //                 title: "¡Advertencia!",
            //                 text: "Debe agregar los platos con sus opciones",
            //                 confirmButtonText: "Aceptar",
            //                 confirmButtonColor: "#3085d6",
            //                 allowOutsideClick: false,
            //             }).then((result) => {
            //                 if (result.value) {
            //                     boxUploadOptions.focus();
            //                 }
            //             });
            //             return false;
            //         }
            //     }
            // }
        }
    );
});

btnGuardar.on("click", function () {
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

    if (files.val() == "") {
        Swal.fire({
            type: "warning",
            title: "¡Advertencia!",
            text: "Debe seleccionar al menos un archivo",
            confirmButtonText: "Aceptar",
            confirmButtonColor: "#3085d6",
            allowOutsideClick: false,
        });
        return false;
    }
    
    if (tipoMenu.val() == null) {        
        Swal.fire({
            type: "warning",
            title: "¡Advertencia!",
            text: "Debe seleccionar un tipo de menú",
            confirmButtonText: "Aceptar",
            confirmButtonColor: "#3085d6",
            allowOutsideClick: false,
        });
        return false;
    }

    if (
        tipoMenu.val() == "Menu a Elegir con Precio" ||
        tipoMenu.val() == "Menu a Elegir sin Precio"
    ) {
        if (boxUploadOptions.val() == "") {
            Swal.fire({
                type: "warning",
                title: "¡Advertencia!",
                text: "Debe agregar los platos con sus opciones",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#3085d6",
                allowOutsideClick: false,
            }).then((result) => {
                if (result.value) {
                    boxUploadOptions.focus();
                }
            });
            return false;
        }
    }
    agregarInvitacion();    

    async function agregarInvitacion() {
        const data = new FormData();
        data.append("titulo", titulo.val());
        data.append("descripcion", CKeditor.getData());
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
