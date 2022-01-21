import "../../../node_modules/izitoast/dist/js/iziToast.min.js";

const cantPersonasRegistradas = document.querySelector(
    "[data-js=cantPersonasRegistradas]"
);
const promAniosRacing = document.querySelector("[data-js=promAniosRacing]");
const nombresRiver = document.querySelector("[data-js=nombresRiver]");
const tablaPersonas = document.querySelector("[data-js=tablaPersonas]");
const tablaEdades = document.querySelector("[data-js=tablaEdades]");

fetch(`/api/data`)
    .then((httpResp) => httpResp.json())
    .then((response) => {
        if (response.status === "success") {
            processData(response.data);
        } else {
            iziToast.error({ message: response.error });
        }
    })
    .catch((e) => {
        iziToast.error({ message: e });
    });

function processData(data) {
    cantPersonasRegistradas.innerHTML = data.cantPersonasRegistradas;
    promAniosRacing.innerHTML = data.promAniosRacing;
    data.nombresRiver.forEach((nombre, i) => {
        i += 1;
        nombresRiver.innerHTML += `<p class="card-text m-0"><b>${i}) ${nombre}</b></p>`;
    });

    data.tablaPersonas.forEach((persona, i) => {
        tablaPersonas.innerHTML += 
            `<tr>
                <th class="text-start" scope="row">${i}</th>
                <td>${persona[0]}</td>
                <td>${persona[1]}</td>
                <td>${persona[2]}</td>
            </tr>`;
    });

    data.tablaEdades.forEach((euipoData) => {
        tablaEdades.innerHTML += 
            `<tr>
                <th scope="row">${euipoData[0]}</th>
                <td>${euipoData[1]}</td>
                <td>${euipoData[2]}</td>
                <td>${euipoData[3]}</td>
                <td>${euipoData[4]}</td>
            </tr>`;
    });
}
