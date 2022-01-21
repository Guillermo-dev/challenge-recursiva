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
            console.log(response.data);
            cantPersonasRegistradas.innerHTML  = response.data.data2
        }else{
            iziToast.error({ message: response.error});
        }
    })
    .catch((e) => {
        iziToast.error({ message: e.error});
    })