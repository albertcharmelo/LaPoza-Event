let btnGuardar = $("#btnGuardar");
let titulo = $("#titulo");
let restaurante = $("#restaurant");
let files = $("#files");
let ckeditorInvitacion = $("#ckeditorInvitacion");
let listDocumentos = $("#listDocumentos");
let tipoMenu = $("#tipoMenu");
let boxUploadMenu = $("#boxUploadMenu");
let boxUploadOptions = $("#boxUploadOptions");
let inputPrice = $("#input_add_price");
let nombre_org = $("#nombre_org");
let email_org = $("#email_org");
let datos_requeridos = $("#datos_requeridos");
let telefono_organizador = document.getElementById("telefono_org");
let fecha_evento = $("#fecha_evento");
let input_file_menu = document.getElementById("input_file_menu");
let name_menu_uploaded = document.getElementById("name_menu_uploaded");
let btn_agregar_email = $("#btn_agregar_email");
let listEmails = $("#listEmails");
btn_agregar_email.prop("disabled", true);
arrayEmailsOrg = [];

let arrayNombresImagenes = [];
let arrayFilesImagenes = [];

let arrayNombresImagenesMenu = [];
let arrayFilesImagenesMenu = [];

let listImagenesMenu = $("#listImagenesMenu");

const maskInputOptions = {
    mask: "000-00-00-00",
};
const telefono_org = IMask(telefono_organizador, maskInputOptions);

$(document).ready(function () {
    // SmartWizard initialize
    var smartWizard = $("#smartwizard").smartWizard({
        keyboardSettings: { keyNavigation: false },
        lang: {
            // Variables de lenguaje
            next: "Siguiente",
            previous: "Anterior", // Cambiar "Previous" a "Anterior"
        },
    });

    // Go to step 1
    smartWizard.smartWizard("goToStep", 0);

    smartWizard.on(
        "leaveStep",
        function (e, anchorObject, stepNumber, stepDirection) {
            if (stepNumber === 0) {
                if (titulo.val() == "" || restaurante.val() == null) {
                    SwalShowMessage(
                        "warning",
                        "¡Advertencia!",
                        "Debe ingresar un título y restaurante"
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
                        document.querySelector("#input_file_menu").files
                            .length == 0
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
            scrollWindowsTop();
        }
    );
    iniciarDatos();
});

function iniciarDatos() {
    titulo.val("");
    CKeditor.setData("");
    files.val("");
    listDocumentos.text("");
    tipoMenu.val("");
    input_file_menu.value = "";
    name_menu_uploaded.innerHTML = "";
    boxUploadOptions.hide();
    platos_with_options = [];
    listResultsPlates.html("");
    actualPlato.text("1º");
    listImagenesMenu.html("");

    arrayNombresImagenes = [];
    arrayFilesImagenes = [];

    arrayNombresImagenesMenu = [];
    arrayFilesImagenesMenu = [];

    nombre_org.val("");
    email_org.val("");

    telefono_org.value = "";
    let fecha = new Date();
    let dia = fecha.getDate();
    let mes = fecha.getMonth() + 1;
    let anio = fecha.getFullYear();
    if (dia < 10) dia = "0" + dia;
    if (mes < 10) mes = "0" + mes;
    fecha_evento.val(anio + "-" + mes + "-" + dia);

    if (invitacion_edit != null) {
        titulo.val(invitacion_edit.titulo);
        if (invitacion_edit.evento.restaurante_id != null) {
            restaurante.val(invitacion_edit.evento.restaurante_id);
        }
        if (invitacion_edit.texto != null) {
            CKeditor.setData(invitacion_edit.texto);
        }

        invitacion_edit.imagenes.forEach(function (imagen) {
            if (imagen.pivot.tipo_imagen == "imagen") {
                arrayFilesImagenes.push(imagen);
                arrayNombresImagenes.push(imagen.nombre);
                mostrarDocumentos();
            } else {
                arrayFilesImagenesMenu.push(imagen);
                arrayNombresImagenesMenu.push(imagen.nombre);
                mostrarImagenesMenu();
            }
        });

        tipoMenu.val(invitacion_edit.tipo_menu);
        if (
            tipoMenu.val() == "Menu a Elegir con Precio" ||
            tipoMenu.val() == "Menu a Elegir sin Precio"
        ) {
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
        telefono_org.value = invitacion_edit.evento.telefono_organizador;
        fecha_evento.val(invitacion_edit.evento.fecha);
        if (invitacion_edit.evento.email_organizador) {
            var emails = invitacion_edit.evento.email_organizador;
            // Si emails es una cadena, conviértela en una matriz con un solo elemento
            if (emails[0] === '[') {
                emails = JSON.parse(emails);
            } else {
                // Si no es un corchete, asumimos que es una cadena y la convertimos en una matriz con un solo elemento
                emails = [emails];
            }
            showEmailsOrg(emails);
        }        
    }
}

function showEmailsOrg(emails) {
    listEmails.html("");
    arrayEmailsOrg = [];
    emails.forEach(function(email) {
        let html = `<span class="badge badge-pill badge-primary mb-1" style="margin-right: 5px;">${email} <button class="close" style="padding-left: 5px; padding-right: 5px; border-radius: 50%;">&times;</button></span>`;
        let badge = $(html);
        badge.find('button').on('click', function() {
            let index = arrayEmailsOrg.indexOf(email);
            if (index > -1) {
                arrayEmailsOrg.splice(index, 1);
            }
            badge.remove();
        });
        listEmails.append(badge);
        arrayEmailsOrg.push(email);
    }); 
}

function mostrarDocumentos() {
    listDocumentos.html("");
    arrayFilesImagenes.sort(function (a, b) {
        if (a.nombre > b.nombre) {
            return 1;
        }
        if (a.nombre < b.nombre) {
            return -1;
        }
        // a must be equal to b
        return 0;
    });
    arrayFilesImagenes.forEach(function (imagen, i) {
        let base64Data = imagen.imagen_base64;
        let formato = imagen.formato;
        let prefix = setPrefix(formato);
        let pag = "";

        let html2;
        let url = imagen.url;
        if (formato === "application/pdf" && url != null) {
            html2 = ` <img class="img-fluid" id="preview${i + 1}"
            src="${url}" alt="">`;
            pag = " (" + imagen.imagen_base64 + ")";
        } else if (formato === "application/pdf" && url == null) {
            html2 = ` <object class="img-fluid" data="${prefix}${base64Data}" type="application/pdf" 
            style="height: 200px !important; object-fit: cover;"></object>`;
        } else {
            let formattedData = `${prefix}${base64Data}`;
            html2 = `<img class="img-fluid" id="preview${i + 1}"
            src="${formattedData}" alt="">`;
        }

        let html = `
            <div class="col-xl-3 col-lg-6 col-sm-6" id="file${i + 1}">
                <div class="card">
                    <div class="card-body">
                        <div class="new-arrival-product">
                            <div class="new-arrivals-img-contnent"> 
                                ${html2}                               
                            </div>
                            <div class="new-arrival-content text-center mt-3">
                                <h4>${imagen.nombre} ${pag}</h4>
                                <button class="delete-button2" data-index="${
                                    i + 1
                                }" 
                                    onclick="eliminarDocumento('${imagen.id}')">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
        listDocumentos.append(html);
    });
}

function mostrarImagenesMenu() {
    listImagenesMenu.html("");
    name_menu_uploaded.innerHTML = "";
    input_file_menu.files = null;
    let dt = new DataTransfer();

    arrayFilesImagenesMenu.sort(function (a, b) {
        if (a.nombre > b.nombre) {
            return 1;
        }
        if (a.nombre < b.nombre) {
            return -1;
        }
        return 0;
    });

    arrayFilesImagenesMenu.forEach(function (imagen, i) {
        let base64Data = imagen.imagen_base64;
        let formato = imagen.formato;
        let prefix = setPrefix(formato);
        let formattedData = `${prefix}${base64Data}`;
        let html2;
        let pag = "";
        let url = imagen.url;
        if (formato === "application/pdf" && url != null) {
            html2 = ` <img class="img-fluid" id="preview${
                i + 1
            }" src="${url}" alt="" style="height: 200px !important;">`;
            pag = " (" + imagen.imagen_base64 + ")";
        } else if (formato === "application/pdf" && url == null) {
            html2 = ` <object class="img-fluid" data="${formattedData}" type="application/pdf" 
            style="height: 200px !important; object-fit: cover;"></object>`;
        } else {
            html2 = `<img class="img-fluid" id="preview${
                i + 1
            }" src="${formattedData}" alt="">`;
        }

        let html =
            `
            <div class="col-xl-3 col-lg-6 col-sm-6" id="file2${i + 1}">
                <div class="card">
                    <div class="card-body">
                        <div class="new-arrival-product">
                            <div class="new-arrivals-img-contnent">` +
            html2 +
            ` 
                            </div>
                            <div class="new-arrival-content text-center mt-3">
                                <h4>${imagen.nombre} ${pag}</h4>
                                <button class="delete-button2" data-index2="${
                                    i + 1
                                }" 
                                    onclick="eliminarDocumento('${
                                        imagen.id
                                    }')">Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
        listImagenesMenu.append(html);
        name_menu_uploaded.innerHTML =
            '<br><span class="badge badge-pill badge-primary">' +
            imagen.nombre +
            "</span>";

        if (imagen) {
            dt.items.add(
                new File([formattedData], imagen.nombre, {
                    type: imagen.formato,
                })
            );
        }
    });
    input_file_menu.files = dt.files;
}

function setPrefix(formato) {
    let prefix;
    switch (formato) {
        case "image/jpeg":
        case "image/jpg":
        case "image/png":
            prefix = "data:image/jpeg;base64,";
            break;
        case "application/pdf":
            prefix = "data:application/pdf;base64,";
            break;
        case "image/gif":
            prefix = "data:image/gif;base64,";
            break;
        default:
            prefix = "data:image/jpeg;base64,";
            break;
    }
    return prefix;
}

function eliminarDocumento(imagen_id) {
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
                    if (data.invitacion_imagen_delete.tipo_imagen == "imagen") {
                        for (let i = 0; i < arrayFilesImagenes.length; i++) {
                            if (arrayFilesImagenes[i].id == imagen_id) {
                                arrayFilesImagenes.splice(i, 1);
                            }
                        }
                        for (let i = 0; i < arrayNombresImagenes.length; i++) {
                            if (
                                arrayNombresImagenes[i] == data.documento.nombre
                            ) {
                                arrayNombresImagenes.splice(i, 1);
                            }
                        }
                        mostrarDocumentos();
                    } else if (
                        data.invitacion_imagen_delete.tipo_imagen == "menu"
                    ) {
                        for (
                            let i = 0;
                            i < arrayFilesImagenesMenu.length;
                            i++
                        ) {
                            if (arrayFilesImagenesMenu[i].id == imagen_id) {
                                arrayFilesImagenesMenu.splice(i, 1);
                            }
                        }
                        for (
                            let i = 0;
                            i < arrayNombresImagenesMenu.length;
                            i++
                        ) {
                            if (
                                arrayNombresImagenesMenu[i] ==
                                data.documento.nombre
                            ) {
                                arrayNombresImagenesMenu.splice(i, 1);
                            }
                        }
                        mostrarImagenesMenu();
                    }
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

    if (arrayEmailsOrg.length == 0) {
        SwalShowMessage(
            "warning",
            "¡Advertencia!",
            "Debe ingresar al menos un email de organizador"
        );
        return false;
    }

    agregarInvitacion();

    async function agregarInvitacion() {
        const data = new FormData();
        data.append("restaurante_id", restaurante.val());
        data.append("titulo", titulo.val());
        data.append("descripcion", CKeditor.getData());
        data.append("tipoMenu", tipoMenu.val());
        data.append("platos_opciones", JSON.stringify(platos_opciones_obj));

        if (invitacion_edit == null) {
            if (arrayFilesImagenes.length > 0) {
                const filePromises = arrayFilesImagenes.map((file, index) => {
                    return getBase64(file.documento).then((base64File) => {
                        data.append(`files[${index}][base64]`, base64File);
                        data.append(`files[${index}][name]`, file.documento.name);
                        data.append(`files[${index}][type]`, file.documento.type);
                        data.append(`files[${index}][size]`, file.documento.size);                        
                        data.append(`files[${index}][url]`, file.url);
                        data.append(`files[${index}][pag]`, file.pag);
                    });
                });
                await Promise.all(filePromises);
            }

            if (arrayFilesImagenesMenu.length > 0) {
                const fileMenuPromises = arrayFilesImagenesMenu.map(
                    (file, index) => {
                        return getBase64(file.documento).then((base64File) => {
                            data.append(
                                `filesMenu[${index}][base64]`,
                                base64File
                            );
                            data.append(
                                `filesMenu[${index}][name]`,
                                file.documento.name
                            );
                            data.append(
                                `filesMenu[${index}][type]`,
                                file.documento.type
                            );
                            data.append(
                                `filesMenu[${index}][size]`,
                                file.documento.size.toString()
                            );
                            data.append(`filesMenu[${index}][url]`, file.url);
                            data.append(`filesMenu[${index}][pag]`, file.pag);
                        });
                    }
                );
                await Promise.all(fileMenuPromises);
            }
        }

        data.append("nombre_org", nombre_org.val());
        data.append("email_org", JSON.stringify(arrayEmailsOrg));
        data.append("telefono_org", telefono_org.value);
        data.append("fecha_evento", fecha_evento.val());
        data.append("datos_requeridos", datos_requeridos.val());
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
                            confirmButtonText: "Aceptarlo",
                            confirmButtonColor: "#fc410c",
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.value) {
                                window.location.href =
                                    "/eventos/" + data.data.evento_id + "/true";
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

$("#listDocumentos").on("click", ".delete-button", function () {
    var index = $(this).data("index"); // Obtener el índice del archivo
    arrayFilesImagenes.splice(index, 1); // Eliminar el archivo de arrayFilesImagenes
    arrayNombresImagenes.splice(index, 1);
    $(this).closest(".col-xl-3").remove(); // Eliminar la vista previa del archivo

    // Actualizamos los atributos id de los archivos restantes.
    $("#listDocumentos .col-xl-3").each(function (i) {
        $(this).attr("id", "file" + i);
        $(this).find(".delete-button").data("index", i);
        $(this)
            .find("img")
            .attr("id", "preview" + i);
    });
});

document.querySelector("#files").addEventListener("change", function (e) {
    var file = this.files[this.files.length - 1];

    nuevoDocumento(file, e);
    async function nuevoDocumento(documento, e) {
        var fileName = documento.name;
        let formato = documento.type;

        // verificamos que el tamaño del documento no sea mayor a 16MB
        if (documento.size > 16777216) {
            SwalShowMessage(
                "warning",
                "¡Advertencia!",
                "El documento " + fileName + " es demasiado grande."
            );
            return false;
        }
        // verificamos que las extensiones del documento sean solo tipo imagen
        var extensiones_permitidas = new Array(
            ".png",
            ".jpg",
            ".jpeg",
            ".gif",
            ".pdf"
        );
        var permitida = false;
        for (var i = 0; i < extensiones_permitidas.length; i++) {
            if (fileName.toLowerCase().endsWith(extensiones_permitidas[i])) {
                permitida = true;
                break;
            }
        }
        if (!permitida) {
            SwalShowMessage(
                "warning",
                "¡Advertencia!",
                "El documento " +
                    fileName +
                    " tiene una extensión no permitida."
            );
            $("#files").val("");
            return false;
        }

        if (
            arrayNombresImagenes.filter((imagen) => imagen == fileName)
                .length == 0
        ) {
            // if (invitacion_edit == null) {
            //     arrayNombresImagenes.push(fileName);
            // }
        } else {
            SwalShowMessage(
                "warning",
                "¡Advertencia!",
                "El documento " + fileName + " ya ha sido seleccionado."
            );
            return false;
        }

        if (invitacion_edit == null) {
            arrayNombresImagenes.push(fileName);
            if (formato === "application/pdf") {
                let fileInput = document.getElementById("files");
                let arrayUrls = await pdfToImage(fileInput);
                if (arrayUrls.length > 0) {
                    let pag = 0;
                    arrayUrls.forEach((file, index) => {
                        pag++;
                        arrayFilesImagenes.push({
                            documento: documento,
                            url: file,
                            pag:
                                arrayUrls.length > 1
                                    ? pag + " de " + arrayUrls.length
                                    : "",
                        });

                        let html2 = ` <img class="img-fluid" id="preview${
                            arrayFilesImagenes.length - 1
                        }" src="${file}" alt="" style="height: 200px !important;">`;

                        let paginacion =
                            arrayUrls.length > 1
                                ? pag + " de " + arrayUrls.length
                                : "";

                        let html = `
                            <div class="col-xl-3 col-lg-6 col-sm-6" 
                            id="file${arrayFilesImagenes.length - 1}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="new-arrival-product">
                                        <div class="new-arrivals-img-contnent">
                                            ${html2}                            
                                        </div>
                                        <div class="new-arrival-content text-center mt-3">
                                            <h4>${fileName} ${paginacion}</h4>
                                            <button class="delete-button" data-index="${
                                                arrayFilesImagenes.length - 1
                                            }">Eliminar</button>                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                        $("#listDocumentos").append(html);
                    });
                }
            } else {
                arrayFilesImagenes.push({
                    documento: documento,
                    url: "",
                    pag: "",
                });
                let html2 = `<img class="img-fluid" id="preview${
                    arrayFilesImagenes.length - 1
                }" alt="">`;

                let html = `
                            <div class="col-xl-3 col-lg-6 col-sm-6" 
                                id="file${arrayFilesImagenes.length - 1}">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="new-arrival-product">
                                            <div class="new-arrivals-img-contnent">
                                                ${html2}                            
                                            </div>
                                            <div class="new-arrival-content text-center mt-3">
                                                <h4>${fileName}</h4> 
                                                <button class="delete-button" data-index="${
                                                    arrayFilesImagenes.length -
                                                    1
                                                }">Eliminar</button>                           
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                $("#listDocumentos").append(html);

                let reader = new FileReader();
                reader.onload = function (e) {
                    document
                        .querySelector(
                            `#preview${arrayFilesImagenes.length - 1}`
                        )
                        .setAttribute("src", e.target.result);
                };
                reader.readAsDataURL(documento);
            }
        } else {
            agregarDocumento("imagen");
        }
    }
});

async function agregarDocumento(tipo_imagen) {
    let documento = "";
    let fileInput = "";
    let tipo = "";
    if (tipo_imagen == "imagen") {
        documento = document.querySelector("#files").files[0];
        fileInput = document.getElementById("files");
        tipo = documento.type;
    } else {
        documento = document.querySelector("#input_file_menu").files[0];
        fileInput = document.getElementById("input_file_menu");
        tipo = documento.type;
    }
    let data = new FormData();
    if (tipo === "application/pdf") {
        arrayUrls = await pdfToImage(fileInput);
        if (arrayUrls.length > 0) {
            data.append("invitacion_id", invitacion_edit.id);
            data.append("tipo_imagen", tipo_imagen);
            let pag = 1;            
            arrayUrls.forEach((file, index) => {                
                data.append(`documento[${index}][name]`, documento.name);
                data.append(
                    `documento[${index}][pag]`,
                    arrayUrls.length > 1 ? pag + " de " + arrayUrls.length : ""
                );

                data.append(`documento[${index}][type]`, documento.type);
                data.append(
                    `documento[${index}][size]`,
                    documento.size.toString()
                );
                data.append(`documento[${index}][url]`, file);
                pag++;
            });            
        }
    } else {
        let pag = "";
        let url = "";
        data.append("invitacion_id", invitacion_edit.id);
        data.append("tipo_imagen", tipo_imagen);
        data = await appendDocumentoToFormData(documento, data, url, pag);
    }

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
                    SwalShowMessage("success", "¡Éxito!", data.message);
                    if (tipo_imagen == "imagen") {
                        arrayFilesImagenes = data.imagenes;
                        arrayNombresImagenes = arrayFilesImagenes.map(
                            (imagen) => imagen.nombre
                        );
                        if (arrayFilesImagenes.length > 0) {
                            arrayFilesImagenes = arrayFilesImagenes.filter(
                                (imagen) => imagen.pivot.tipo_imagen == "imagen"
                            );
                            mostrarDocumentos();
                        }
                    } else {
                        arrayFilesImagenesMenu = data.imagenes;
                        arrayNombresImagenesMenu = arrayFilesImagenesMenu.map(
                            (imagen) => imagen.nombre
                        );

                        if (arrayFilesImagenesMenu.length > 0) {
                            arrayFilesImagenesMenu =
                                arrayFilesImagenesMenu.filter(
                                    (imagen) =>
                                        imagen.pivot.tipo_imagen == "menu"
                                );
                        }
                        mostrarImagenesMenu();
                    }
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

async function appendDocumentoToFormData(documento, data, url, pag) {
    const base64File = await getBase64(documento);
    data.append("documento[0][base64]", base64File);    
    data.append("documento[0][name]", documento.name);
    data.append("documento[0][type]", documento.type);
    data.append("documento[0][size]", documento.size.toString());
    data.append("documento[0][url]", url);
    data.append("documento[0][pag]", pag);
    return data;
}

tipoMenu.on("change", function () {
    platos_with_options = [];
    listResultsPlates.html("");
    opciones_de_platos = [];

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

$("#listImagenesMenu").on("click", ".delete-button", function () {
    var index = $(this).data("index2"); // Obtener el índice del archivo
    arrayFilesImagenesMenu.splice(index, 1); // Eliminar el archivo de arrayFilesImagenes
    arrayNombresImagenesMenu.splice(index, 1);
    $(this).closest(".col-xl-3").remove(); // Eliminar la vista previa del archivo

    // Actualizamos los atributos id de los archivos restantes.
    $("#listImagenesMenu .col-xl-3").each(function (i) {
        $(this).attr("id", "file2" + i);
        $(this).find(".delete-button").data("index2", i);
        $(this)
            .find("img")
            .attr("id", "preview2" + i);
    });
});

async function ShowNameMenuUploaded(e) {
    var fileName = "";
    var documento;
    var nombre_archivo = "";
    for (var i = 0; i < e.srcElement.files.length; i++) {
        fileName +=
            '<br><span class="badge badge-pill badge-primary">' +
            e.srcElement.files[i].name +
            "</span>";
        documento = e.srcElement.files[i];
        nombre_archivo = e.srcElement.files[i].name;
    }
    document.getElementById("name_menu_uploaded").innerHTML = fileName;

    let formato = documento.type;

    if (documento.size > 16777216) {
        SwalShowMessage(
            "warning",
            "¡Advertencia!",
            "El archivo " + nombre_archivo + " es demasiado grande."
        );
        return false;
    }

    if (
        arrayNombresImagenesMenu.filter((imagen) => imagen == nombre_archivo)
            .length > 0
    ) {
        SwalShowMessage(
            "warning",
            "¡Advertencia!",
            "El archivo " + nombre_archivo + " ya ha sido seleccionado."
        );
        return false;
    }

    // verificamos que las extensiones del archivo sean solo tipo imagen
    var extensiones_permitidas = new Array(
        ".png",
        ".jpg",
        ".jpeg",
        ".gif",
        ".pdf"
    );
    var permitida = false;
    for (var i = 0; i < extensiones_permitidas.length; i++) {
        if (nombre_archivo.toLowerCase().endsWith(extensiones_permitidas[i])) {
            permitida = true;
            break;
        }
    }

    if (!permitida) {
        SwalShowMessage(
            "warning",
            "¡Advertencia!",
            "El archivo " +
                nombre_archivo +
                " tiene una extensión no permitida."
        );
        $("#input_file_menu").val("");
        document.getElementById("name_menu_uploaded").innerHTML = "";
        return false;
    }

    if (invitacion_edit == null) {
        arrayNombresImagenesMenu.push(nombre_archivo);
        if (formato === "application/pdf") {
            let arrayUrls = await pdfToImage(input_file_menu);
            if (arrayUrls.length > 0) {                
                let pag = 0;
                arrayUrls.forEach((file, index) => {
                    pag++;                    
                    arrayFilesImagenesMenu.push({
                        documento: documento,
                        url: file,
                        pag:
                            arrayUrls.length > 1
                                ? pag + " de " + arrayUrls.length
                                : "",
                    });
                    
                    let html2 = ` <img class="img-fluid" 
                            id="preview2${
                                arrayNombresImagenesMenu.length - 1
                            }" src="${file}" alt="" style="height: 200px !important;">`;

                    let paginacion =
                        arrayUrls.length > 1
                            ? pag + " de " + arrayUrls.length
                            : "";

                    let html = `
                        <div class="col-xl-3 col-lg-6 col-sm-6" id="file2${
                            arrayNombresImagenesMenu.length - 1
                        }">
                            <div class="card">
                                <div class="card-body">
                                    <div class="new-arrival-product">
                                        <div class="new-arrivals-img-contnent">
                                            ${html2}
                                        </div>
                                        <div class="new-arrival-content text-center">
                                            <h4>${fileName} ${paginacion}</h4>
                                            <button class="delete-button" data-index2="${
                                                arrayNombresImagenesMenu.length -
                                                1
                                            }">Eliminar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    $("#listImagenesMenu").append(html);
                });
            }
        } else {            
            arrayFilesImagenesMenu.push({
                documento: documento,
                url: "",
                pag: "",
            });

            html2 = `<img class="img-fluid" id="preview2${
                arrayNombresImagenesMenu.length - 1
            }" alt="">`;
            let html = `
            <div class="col-xl-3 col-lg-6 col-sm-6" id="file2${
                arrayNombresImagenesMenu.length - 1
            }">
                <div class="card">
                    <div class="card-body">
                        <div class="new-arrival-product">
                            <div class="new-arrivals-img-contnent">
                                ${html2}
                            </div>
                            <div class="new-arrival-content text-center">
                                <h4>${fileName}</h4>
                                <button class="delete-button" data-index2="${
                                    arrayNombresImagenesMenu.length - 1
                                }">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
            $("#listImagenesMenu").append(html);

            
            let reader = new FileReader();
            reader.onload = function (e) {
                document
                    .querySelector(
                        `#preview2${arrayNombresImagenesMenu.length - 1}`
                    )
                    .setAttribute("src", e.target.result);
            };
            reader.readAsDataURL(documento);
        }
    } else {
        actualizarImagenMenu();
        async function actualizarImagenMenu() {
            agregarDocumento("menu");
        }
    }
}

function showLoader() {
    $("#loader_page").show();
}
function hideLoader() {
    $("#loader_page").hide();
}

async function pdfToImage(fileInput) {
    var myHeaders = new Headers();
    myHeaders.append(
        "Authorization",
        "Bearer 15|50kBFXqp1lZo7hfYo5TKooRFi5HkorOLdIvkkiUn"
    );

    var formdata = new FormData();
    formdata.append("carpeta", "1vS2td1goublvEU7Y5R7ILZNFhvqKWuP0");
    formdata.append("pdf", fileInput.files[0], "[PROXY]");

    var requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: formdata,
        redirect: "follow",
    };
    showLoader();

    let response = await fetch(
        "https://storage.worki.es/api/convertirPdfToImg",
        requestOptions
    )
        .then((response) => response.json())
        .then((result) => {
            let nombres_archivos = result.map((item) => item.name);
            return nombres_archivos;
        })
        .catch((error) => console.log("error", error))
        .finally(() => {
            hideLoader();
        });
    return response;
}

email_org.on("keyup", function () {
    if (email_org.val() != "") {
        if (!validateEmail(email_org.val())) {           
            btn_agregar_email.prop("disabled", true);
        } else {           
            btn_agregar_email.prop("disabled", false);
        }
    } else {       
        btn_agregar_email.prop("disabled", true);
    }
});


btn_agregar_email.on("click", function () {
    var email = email_org.val();    
    if (email) {        
        let html = `<span class="badge badge-pill badge-primary mb-1" style="margin-right: 5px;">${email} <button class="close" style="padding-left: 5px; padding-right: 5px; border-radius: 50%;">&times;</button></span>`;
        let badge = $(html);
        badge.find('button').on('click', function() {
            let index = arrayEmailsOrg.indexOf(email);
            if (index > -1) {
                arrayEmailsOrg.splice(index, 1);
            }
            badge.remove();
        });
        listEmails.append(badge);
        arrayEmailsOrg.push(email);
        email_org.val("");        
        btn_agregar_email.prop("disabled", true);
    }
});