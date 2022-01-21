import "../../../node_modules/izitoast/dist/js/iziToast.min.js";

const cantPersonasRegistradas = document.querySelector('[data-js=cantPersonasRegistradas]')
const promAniosRacing = document.querySelector('[data-js=promAniosRacing]')
const nombresRiver = document.querySelector('[data-js=nombresRiver]')
const tablaPersonas = document.querySelector('[data-js=tablaPersonas]')
const tablaEdades = document.querySelector('[data-js=tablaEdades]')

fetch(`/api/data`)
    .then((httpResp) => httpResp.json())
    .then((response) => {
        if(response.status === "success") {
            processData(response.data)
        }else{
            console.log(response.error)
            iziToast.error({ message: response.error});
        }
    })
    .catch((e) => {
        console.log(e)
        iziToast.error({ message: e});
    })

function processData(data) {
    cantPersonasRegistradas.innerHTML  = data.cantPersonasRegistradas;
    promAniosRacing.innerHTML = data.promAniosRacing;
    data.nombresRiver.forEach((nombre, i) => {
        i += 1;
        nombresRiver.innerHTML += `<p class="card-text m-0"><b>${i}) ${nombre}</b></p>`;
    });

}