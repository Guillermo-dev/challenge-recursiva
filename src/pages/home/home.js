import "../../../node_modules/izitoast/dist/js/iziToast.min.js";

const formArchivo = document.querySelector("[data-js=formArchivo]");
const inputArchivo = document.querySelector("[data-js=inputArchivo]");
const btnEnviar = document.querySelector("[data-js=btnEnviar]");

inputArchivo.onchange = InputArchivoOnchange;
formArchivo.onsubmit = submitArchivo;

function InputArchivoOnchange() {
    if (inputArchivo.files[0].type !== "application/vnd.ms-excel") {
        iziToast.error({ message: "Formato de archivo no valido", position: 'bottomLeft' });
        inputArchivo.value = "";
        btnEnviar.disabled = true;
    } else {
        btnEnviar.disabled = false;
    }
}

function submitArchivo(event) {
    event.preventDefault();
    btnEnviar.disabled = true;
    btnEnviar.lastElementChild.classList.remove("d-none");

    const formData = new FormData();
    formData.append("personasInfo", inputArchivo.files[0]);

    fetch(`/api/procesarArchivo`, { method: "POST", body: formData })
        .then((httpResp) => httpResp.json())
        .then((response) => {
            if (response.status === "success") {
                window.location.href = "/data";
            } else {
                btnEnviar.disabled = false;
                btnEnviar.lastElementChild.classList.add("d-none");
                iziToast.error({ message: response.error, position: 'bottomLeft'});
            }
        })
        .catch((e) => {
            btnEnviar.disabled = false;
            btnEnviar.lastElementChild.classList.add("d-none");
            iziToast.error({ message: e.error , position: 'bottomLeft'});
        });
}
