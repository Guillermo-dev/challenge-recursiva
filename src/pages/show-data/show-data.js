import "../../../node_modules/izitoast/dist/js/iziToast.min.js";

const cantPersonasRegistradas = document.querySelector(
    "[data-js=cantPersonasRegistradas]"
);
const promEdadRacing = document.querySelector("[data-js=promEdadRacing]");
const nombresRiver = document.querySelector("[data-js=nombresRiver]");
const tablaPersonas = document.querySelector("[data-js=tablaPersonas]");
const tablaEdades = document.querySelector("[data-js=tablaEdades]");

fetch(`/api/data`)
    .then((httpResp) => httpResp.json())
    .then((response) => {
        if (response.status === "success") {
            processData(response.data);
        } else {
            iziToast.error({ message: response.error, position: 'bottomLeft'});
        }
    })
    .catch((e) => {
        iziToast.error({ message: e, position: 'bottomLeft'});
    });

function processData(data) {
    // Vista de cantidad de personas registradas
    cantPersonasRegistradas.innerHTML = data.cantPersonasRegistradas;

    // Vista de Promedio de edades de racing
    promEdadRacing.innerHTML = data.promEdadRacing;

    // Vista de 5 nombres mas comunes river
    data.nombresRiver.forEach((nombre, i) => {
        nombresRiver.innerHTML += `<p class="card-text m-0"><b>${i+1}) ${nombre}</b></p>`;
    });

    // Vista tabla de primeras 100 personas
    data.tablaPersonas.forEach((persona, i) => {
        tablaPersonas.innerHTML += 
            `<tr>
                <th scope="row">${i+1}</th>
                <td>${persona.nombre}</td>
                <td>${persona.edad}</td>
                <td>${persona.equipo}</td>
            </tr>`;
    });

    // Vista tabla de equipos por cantidad de socios
    data.tablaEdades.forEach((euipoData) => {
        console.log(euipoData)
        tablaEdades.innerHTML += 
            `<tr>
                <th scope="row">${euipoData.cantSocios}</th>
                <td>${euipoData.equipo}</td>
                <td>${euipoData.promEdad}</td>
                <td>${euipoData.minEdad}</td>
                <td>${euipoData.maxEdad}</td>
            </tr>`;
    });
}
