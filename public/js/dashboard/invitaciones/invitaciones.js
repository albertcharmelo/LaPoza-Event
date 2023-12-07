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

let arrayNombresImagenesMenu = [];
let arrayFilesImagenesMenu = [];

let listImagenesMenu = $("#listImagenesMenu");

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
                        document.querySelector("#input_file_menu").files.length == 0 
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
    arrayImagenesFiles = [];
    filesArray = [];
    platos_with_options = [];
    listResultsPlates.html("");
    actualPlato.text("1º");

    listImagenesMenu.html("");
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
        if (invitacion_edit.texto != null) {
            CKeditor.setData(invitacion_edit.texto);
        }

        invitacion_edit.imagenes.forEach(function (imagen) {
            if (imagen.pivot.tipo_imagen == "imagen") {
                arrayImagenesFiles.push(imagen);
                mostrarDocumentos();
            } else {
                arrayFilesImagenesMenu.push(imagen);
                arrayNombresImagenesMenu.push(imagen.nombre);
                mostrarImagenesMenu();
            }
        });

        tipoMenu.val(invitacion_edit.tipo_menu);        
        input_file_menu.value = "";
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
        email_org.val(invitacion_edit.evento.email_organizador);
        telefono_org.value = invitacion_edit.evento.telefono_organizador;
        fecha_evento.val(invitacion_edit.evento.fecha);
    }
}

function mostrarDocumentos() {
    listDocumentos.html("");
    arrayImagenesFiles.forEach(function (imagen, i) {
        let base64Data = imagen.imagen_base64;
        let formato = imagen.formato;
        let prefix = setPrefix(formato);
        let formattedData = `${prefix}${base64Data}`;

        let html2;
        if (formato === "application/pdf") {
            html2 = ` <object class="img-fluid" data="${formattedData}" type="application/pdf" style="height: 200px !important; object-fit: cover;"></object>`;
        } else {
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
                                <h4>${imagen.nombre}</h4>
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
    arrayFilesImagenesMenu.forEach(function (imagen, i) {
        let base64Data = imagen.imagen_base64;
        let formato = imagen.formato;
        let prefix = setPrefix(formato);
        let formattedData = `${prefix}${base64Data}`;

        let html2;
        if (formato === "application/pdf") {
            html2 = ` <object class="img-fluid" data="${formattedData}" type="application/pdf" style="height: 200px !important; object-fit: cover;"></object>`;
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
                                <h4>${imagen.nombre}</h4>
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
    });
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

    agregarInvitacion();

    async function agregarInvitacion() {
        const data = new FormData();
        data.append("titulo", titulo.val());
        data.append("descripcion", CKeditor.getData());
        data.append("tipoMenu", tipoMenu.val());
        data.append("platos_opciones", JSON.stringify(platos_opciones_obj));

        if (invitacion_edit == null) {
            if (filesArray.length > 0) {
                const filePromises = filesArray.map((file, index) => {
                    return getBase64(file).then((base64File) => {
                        data.append(`files[${index}][base64]`, base64File);
                        data.append(`files[${index}][name]`, file.name);
                        data.append(`files[${index}][type]`, file.type);
                        data.append(
                            `files[${index}][size]`,
                            file.size.toString()
                        );
                    });
                });
                await Promise.all(filePromises);
            }

            if (arrayFilesImagenesMenu.length > 0) {
                const fileMenuPromises = arrayFilesImagenesMenu.map(
                    (file, index) => {
                        return getBase64(file).then((base64File) => {
                            data.append(
                                `files_menu[${index}][base64]`,
                                base64File
                            );
                            data.append(
                                `files_menu[${index}][name]`,
                                file.name
                            );
                            data.append(
                                `files_menu[${index}][type]`,
                                file.type
                            );
                            data.append(
                                `files_menu[${index}][size]`,
                                file.size.toString()
                            );
                        });
                    }
                );
                await Promise.all(fileMenuPromises);
            }
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
                        console.log('data:',data);
                        Swal.fire({
                            type: "success",
                            title: "¡Éxito!",
                            text: data.message,
                            confirmButtonText: "Aceptarlo",
                            confirmButtonColor: "#fc410c",
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = "/eventos/" + data.data.evento_id + "/true";
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
    arrayImagenesFiles.splice(index, 1); // Eliminar el archivo de arrayImagenesFiles
    filesArray.splice(index, 1); // Eliminar el archivo de filesArray
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
    var file = this.files[this.files.length - 1]; // Obtener el último archivo seleccionado
    var fileName = file.name;
    let formato = file.type;

    // verificamos que el tamaño del archivo no sea mayor a 16MB
    if (file.size > 16777216) {
        SwalShowMessage(
            "warning",
            "¡Advertencia!",
            "El archivo " + fileName + " es demasiado grande."
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
        if (fileName.toLowerCase().endsWith(extensiones_permitidas[i])) {
            permitida = true;
            break;
        }
    }
    if (!permitida) {
        SwalShowMessage(
            "warning",
            "¡Advertencia!",
            "El archivo " + fileName + " tiene una extensión no permitida."
        );
        $("#files").val("");
        return false;
    }

    if (
        arrayImagenesFiles.filter((imagen) => imagen.nombre == fileName)
            .length == 0
    ) {
        filesArray.push(file);

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

    if (invitacion_edit == null) {
        let html2;
        if (formato === "application/pdf") {
            html2 = ` <object class="img-fluid" id ="preview${
                arrayImagenesFiles.length - 1
            }"  data="" type="application/pdf" style="height: 200px !important; object-fit: cover;"></object>`;
        } else {
            html2 = `<img class="img-fluid" id="preview${
                arrayImagenesFiles.length - 1
            }" alt="">`;
        }

        let html = `
        <div class="col-xl-3 col-lg-6 col-sm-6" id="file${
            arrayImagenesFiles.length - 1
        }">
            <div class="card">
                <div class="card-body">
                    <div class="new-arrival-product">
                        <div class="new-arrivals-img-contnent">
                            ${html2}                            
                        </div>
                        <div class="new-arrival-content text-center mt-3">
                            <h4>${fileName}</h4> 
                            <button class="delete-button" data-index="${
                                arrayImagenesFiles.length - 1
                            }">Eliminar</button>                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
        $("#listDocumentos").append(html);

        if (formato === "application/pdf") {
            let reader = new FileReader();
            reader.onload = function (e) {
                document
                    .querySelector(`#preview${arrayImagenesFiles.length - 1}`)
                    .setAttribute("data", e.target.result);
            };
            reader.readAsDataURL(file);
        } else {
            let reader = new FileReader();
            reader.onload = function (e) {
                document
                    .querySelector(`#preview${arrayImagenesFiles.length - 1}`)
                    .setAttribute("src", e.target.result);
            };
            reader.readAsDataURL(file);
        }
    } else {
        agregarDocumento("imagen");
    }
});

async function agregarDocumento(tipo_imagen) {
    let data = new FormData();
    let documento = "";
    data.append("invitacion_id", invitacion_edit.id);
    if (tipo_imagen == "imagen") {
        documento = document.querySelector("#files").files[0];
    } else {
        documento = document.querySelector("#input_file_menu").files[0];
    }
    data = await appendDocumentoToFormData(documento, data, tipo_imagen);

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
                        arrayImagenesFiles.push(data.imagen);
                        mostrarDocumentos();
                    } else {
                        arrayFilesImagenesMenu.push(data.imagen);
                        arrayNombresImagenesMenu.push(data.imagen.nombre);
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

async function appendDocumentoToFormData(documento, data, tipo_imagen) {
    const base64File = await getBase64(documento);
    data.append("documento[base64]", base64File);
    data.append("documento[name]", documento.name);
    data.append("documento[type]", documento.type);
    data.append("documento[size]", documento.size.toString());
    data.append("tipo_imagen", tipo_imagen);
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
    arrayFilesImagenesMenu.splice(index, 1); // Eliminar el archivo de arrayImagenesFiles
    arrayNombresImagenesMenu.splice(index, 1); // Eliminar el archivo de filesArray
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

function ShowNameMenuUploaded(e) {
    var fileName = "";
    var file;
    var nombre_archivo = "";
    for (var i = 0; i < e.srcElement.files.length; i++) {
        fileName +=
            '<br><span class="badge badge-pill badge-primary">' +
            e.srcElement.files[i].name +
            "</span>";
        file = e.srcElement.files[i];
        nombre_archivo = e.srcElement.files[i].name;
    }
    document.getElementById("name_menu_uploaded").innerHTML = fileName;

    let formato = file.type;

    if (file.size > 16777216) {
        SwalShowMessage(
            "warning",
            "¡Advertencia!",
            "El archivo " + nombre_archivo + " es demasiado grande."
        );
        return false;
    }

    if (
        arrayNombresImagenesMenu.filter((imagen) => imagen == nombre_archivo)
            .length == 0
    ) {
        if (invitacion_edit == null) {
            arrayNombresImagenesMenu.push(nombre_archivo);
            arrayFilesImagenesMenu.push(file);
        }
    } else {
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
        let html2;
        if (formato === "application/pdf") {
            html2 = ` <object class="img-fluid" id ="preview2${
                arrayNombresImagenesMenu.length - 1
            }"  data="" type="application/pdf" style="height: 200px !important; object-fit: cover;"></object>`;
        } else {
            html2 = `<img class="img-fluid" id="preview2${
                arrayNombresImagenesMenu.length - 1
            }" alt="">`;
        }

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

        if (formato === "application/pdf") {
            let reader = new FileReader();
            reader.onload = function (e) {
                document
                    .querySelector(
                        `#preview2${arrayNombresImagenesMenu.length - 1}`
                    )
                    .setAttribute("data", e.target.result);
            };
            reader.readAsDataURL(file);
        } else {
            let reader = new FileReader();
            reader.onload = function (e) {
                document
                    .querySelector(
                        `#preview2${arrayNombresImagenesMenu.length - 1}`
                    )
                    .setAttribute("src", e.target.result);
            };
            reader.readAsDataURL(file);
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
