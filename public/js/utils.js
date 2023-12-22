function scrollWindowsTop() {
    window.scrollTo(0, 0);
}

function copiarEnPortapapeles(texto) {
    var aux = document.createElement("input");
    aux.setAttribute("value", texto);
    document.body.appendChild(aux);
    aux.select();
    document.execCommand("copy");
    document.body.removeChild(aux);
    toastr.success("Contenido copiado al portapapeles", "Copiado!", {
        positionClass: "toast-bottom-right",
        timeOut: 5e3,
        closeButton: !0,
        debug: !1,
        newestOnTop: !0,
        progressBar: !0,
        preventDuplicates: !0,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
        tapToDismiss: !1,
    });
}

async function pdfToImage(inputID) {
    let fileInput = document.getElementById(inputID);
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

    let response = await fetch(
        "https://storage.worki.es/api/convertirPdfToImg",
        requestOptions
    )
        .then((response) => response.json())
        .then((result) => {
            let nombres_archivos = result.map((item) => item.name);
            return nombres_archivos;
        });

    return response;
}

function getCurrentRestautante() {
    const restaurante_id = sessionStorage.getItem("restaurante_id");
    return restaurante_id;
}

function setCurrentRestaurante(
    restaurante_id = document.getElementById("select_restaurant").value
) {
    const select_restaurante = document.getElementById("select_restaurant");
    select_restaurante.value = restaurante_id;
    sessionStorage.setItem("restaurante_id", restaurante_id);
    window.location = "/";
}
