function scrollWindowsTop() {
    window.scrollTo(0, 0);
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
