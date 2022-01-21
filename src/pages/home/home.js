import "../../../node_modules/izitoast/dist/js/iziToast.min.js";

const formArchivo = document.querySelector("[data-js=formArchivo]");
const inputArchivo = document.querySelector("[data-js=inputArchivo]");
const btnEnviar = document.querySelector("[data-js=btnEnviar]");

inputArchivo.onchange = InputArchivoOnchange;
formArchivo.onsubmit = submitArchivo;

function InputArchivoOnchange() {
    if (inputArchivo.files[0].type !== "application/vnd.ms-excel") {
        iziToast.error({ message: "Tipo de archivo invalido" });
        inputArchivo.value = "";
        btnEnviar.disabled = true;
    } else {
        btnEnviar.disabled = false;
    }
}

function submitArchivo(event) {
    event.preventDefault();

    const formData = new FormData();
    formData.append("personasInfo", inputArchivo.files[0]);

    fetch(`/api/procesarArchivo`, { method: "POST", body: formData })
        .then((httpResp) => httpResp.json())
        .then((response) => {
            if (response.status === "success") {
                window.location.href = "/data";
            } else {
                console.log(response)
                iziToast.error({ message: response.error});
            }
        })
        .catch((e) => {
            console.log(e)
            iziToast.error({ message: e.error });
        });
}
