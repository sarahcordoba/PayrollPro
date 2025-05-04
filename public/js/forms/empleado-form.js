let currentStep = 1;

function nextForm(event) {
    if (event) {
        event.preventDefault();
        if (currentStep < 3) {
            document.getElementById('form' + currentStep).style.display = 'none';
            currentStep++;
            document.getElementById('form' + currentStep).style.display = 'block';
            updateSteps();
            updateButtons();
            document.querySelector('.progress-bar-fill').style.width = (currentStep / 3 * 100) + '%';
        }
    }
}

function prevForm(event) {
    if (event) {
        event.preventDefault();
        if (currentStep > 1) {
            document.getElementById('form' + currentStep).style.display = 'none';
            currentStep--;
            document.getElementById('form' + currentStep).style.display = 'block';
            updateSteps();
            updateButtons();
            document.querySelector('.progress-bar-fill').style.width = (currentStep / 3 * 100) + '%';
        }
    }   
}

function updateSteps() {
    for (let i = 1; i <= 3; i++) {
        const stepElement = document.getElementById('step' + i);
        if (i <= currentStep) {
            stepElement.classList.add('active');
        } else {
            stepElement.classList.remove('active');
        }
    }
}

function updateButtons() {
    const nextButton = document.getElementById('nextButton');
    const submitButton = document.getElementById('submitButton');

    if (currentStep === 3) {
        nextButton.style.display = 'none';
        submitButton.style.display = 'inline-block';
    } else {
        nextButton.style.display = 'inline-block';
        submitButton.style.display = 'none';
    }
}

window.onload = function () {
    updateSteps();
    document.getElementById('form' + currentStep).style.display = 'block';
    document.querySelector('.progress-bar-fill').style.width = (currentStep / 3 * 100) + '%';

    // document.getElementById('empleado_form').addEventListener('submit', function (event) {
    //     alert('Formulario enviado correctamente.');
    // });

    document.getElementById('prevButton').addEventListener('click', prevForm);
    document.getElementById('nextButton').addEventListener('click', nextForm);
};


// para que la fecha de fin de contrsto sea posterior a la fecha de inicio de ocntraro
document.addEventListener('DOMContentLoaded', (event) => {
    const hiringDateInput = document.getElementById('fecha_contratacion');
    const contractEndDateInput = document.getElementById('fecha_fin_contrato');

    contractEndDateInput.addEventListener('change', validateDates);
    hiringDateInput.addEventListener('change', validateDates);

    function validateDates() {
        const hiringDate = new Date(hiringDateInput.value);
        const contractEndDate = new Date(contractEndDateInput.value);

        if (contractEndDate < hiringDate) {
            showToast('La fecha de fin de contrato debe ser posterior a la fecha de contratación.');
            contractEndDateInput.value = ''; // Clear the invalid date
        }
    }
});

document.addEventListener('DOMContentLoaded', () => {
    // Llamar a las funciones necesarias al cargar la página
    cargarTiposC();
    cargarMunicipios();
    cargarEPS();
    cargarCajasComp();
    cargarPens();
    cargarCesantias();

    const idNumberInput = document.getElementById('numero_identificacion');
    const phoneInput = document.getElementById('celular');
    const holidayInput = document.getElementById('dias_vacaciones');
    const numCuentaInput = document.getElementById('numero_cuenta');
    const salaryInput = document.getElementById('salario');


    // Permitir solo números y hasta 15 caracteres para el número de identificación
    idNumberInput.addEventListener('input', () => {
        idNumberInput.value = idNumberInput.value.replace(/[^0-9]/g, '').slice(0, 15);
    });

    // Permitir solo números y hasta 15 caracteres para el teléfono
    phoneInput.addEventListener('input', () => {
        phoneInput.value = phoneInput.value.replace(/[^0-9]/g, '').slice(0, 15);
    });

    holidayInput.addEventListener('input', () => {
        holidayInput.value = holidayInput.value.replace(/[^0-9]/g, '').slice(0, 3);
    });

    numCuentaInput.addEventListener('input', () => {
        numCuentaInput.value = numCuentaInput.value.replace(/[^0-9]/g, '').slice(0, 25);
    });

    salaryInput.addEventListener('input', () => {
        salaryInput.value = salaryInput.value.replace(/[^0-9]/g, '').slice(0, 20);
    });


});

//para cargar cosas
async function cargarMunicipios() {
    try {
        // Cargar el archivo JSON
        const response = await fetch('/data/municipios.json');
        const data = await response.json(); // Parsear el JSON

        // Obtener el elemento select
        const selectElement = document.getElementById("municipio");

        // Agregar las opciones dinámicamente
        data.forEach(item => {
            const option = document.createElement("option");
            // Mostrar el municipio y departamento concatenados
            option.value = item.MUNICIPIO;
            option.textContent = `${item.MUNICIPIO}, ${item.DEPARTAMENTO}`;
            selectElement.appendChild(option);
        });
    } catch (error) {
        console.error("Error al cargar el archivo JSON: ", error);
    }
}

async function cargarTiposC() {
    try {
        // Cargar el archivo JSON
        const response = await fetch('/data/tipo_cotizacion.json');
        const data = await response.json(); // Parsear el JSON

        // Obtener el elemento select
        const selectElement = document.getElementById("tipo_trabajador");
        const salarioInput = document.getElementById("salario"); // Asegúrate de que este sea el id de tu campo de salario

        const tiposConSalarioCero = [12, 19, 21, 42];

        // Agregar las opciones dinámicamente al select
        data.forEach(item => {
            const option = document.createElement("option");
            option.value = item.id;
            option.textContent = item.description;
            selectElement.appendChild(option);
        });

        // Agregar un evento de cambio para la selección del tipo de cotizante
        selectElement.addEventListener('change', () => verificarSalario(tiposConSalarioCero, selectElement, salarioInput));
        // Agregar un evento al campo de salario para verificar cuando el campo pierde el foco
        salarioInput.addEventListener('blur', () => verificarSalario(tiposConSalarioCero, selectElement, salarioInput));

    } catch (error) {
        console.error("Error al cargar el archivo JSON: ", error);
    }
}

async function cargarEPS() {
    try {
        // Cargar el archivo JSON
        const response = await fetch('/data/eps.json');
        const data = await response.json(); // Parsear el JSON

        // Obtener el elemento select
        const selectElement = document.getElementById("eps");

        // Agregar las opciones dinámicamente
        data.forEach(item => {
            const option = document.createElement("option");
            // Mostrar el municipio y departamento concatenados
            option.value = item.nombre;
            option.textContent = `${item.nombre}`;
            selectElement.appendChild(option);
        });
    } catch (error) {
        console.error("Error al cargar el archivo JSON: ", error);
    }
}

async function cargarCajasComp() {
    try {
        // Cargar el archivo JSON
        const response = await fetch('/data/cajasdecompen.json');
        const data = await response.json(); // Parsear el JSON

        // Obtener el elemento select
        const selectElement = document.getElementById("caja_compensacion");

        // Agregar las opciones dinámicamente
        data.forEach(item => {
            const option = document.createElement("option");
            // Mostrar el municipio y departamento concatenados
            option.value = item.nombre;
            option.textContent = `${item.nombre}`;
            selectElement.appendChild(option);
        });
    } catch (error) {
        console.error("Error al cargar el archivo JSON: ", error);
    }
}

async function cargarPens() {
    try {
        // Cargar el archivo JSON
        const response = await fetch('/data/pensiones.json');
        const data = await response.json(); // Parsear el JSON

        // Obtener el elemento select
        const selectElement = document.getElementById("fondo_pensiones");

        // Agregar las opciones dinámicamente
        data.forEach(item => {
            const option = document.createElement("option");
            // Mostrar el municipio y departamento concatenados
            option.value = item.nombre;
            option.textContent = `${item.nombre}`;
            selectElement.appendChild(option);
        });
    } catch (error) {
        console.error("Error al cargar el archivo JSON: ", error);
    }
}

async function cargarCesantias() {
    try {
        // Cargar el archivo JSON
        const response = await fetch('/data/cesantias.json');
        const data = await response.json(); // Parsear el JSON

        // Obtener el elemento select
        const selectElement = document.getElementById("fondo_cesantias");

        // Agregar las opciones dinámicamente
        data.forEach(item => {
            const option = document.createElement("option");
            // Mostrar el municipio y departamento concatenados
            option.value = item.nombre;
            option.textContent = `${item.nombre}`;
            selectElement.appendChild(option);
        });
    } catch (error) {
        console.error("Error al cargar el archivo JSON: ", error);
    }
}

function verificarSalario(tiposConSalarioCero, tipoCotizanteId, salarioInput) {
    const salario = parseFloat(salarioInput.value); // Valor del salario ingresado

    // Verificamos si el tipo de cotizante tiene salario 0 y el salario no es 0
    if (tiposConSalarioCero.includes(tipoCotizanteId) && salario !== 0) {
        showToast('¡Error! Los cotizantes de este tipo deben tener un salario de 0.');
        selectElement.value = ''; // Restablecer a un valor por defecto, por ejemplo, vacío

    }
}

document.addEventListener('DOMContentLoaded', function () {
    const paymentMethodSelect = document.getElementById('metodo_pago');
    const transferenciaInfo = document.getElementById('transferencia_info');
    const bancoSelect = document.getElementById('banco');
    const numeroCuentaInput = document.getElementById('numero_cuenta');
    const tipoCuentaSelect = document.getElementById('tipo_cuenta');

    // Función para actualizar los campos de pago
    const actualizarCamposPago = function () {
        console.log(paymentMethodSelect.value);

        if (paymentMethodSelect.value === 'pago_efectivo') {
            // Si es "pago_efectivo", ocultar los campos de transferencia bancaria y vaciarlos
            transferenciaInfo.style.display = 'none';

            // Vaciar los campos de transferencia bancaria
            bancoSelect.value = null;
            numeroCuentaInput.value = '';
            tipoCuentaSelect.value = null;
        } else if (paymentMethodSelect.value === 'transferencia_bancaria') {
            // Si es "transferencia_bancaria", mostrar los campos de transferencia bancaria
            transferenciaInfo.style.display = 'block';
        } else {
            // Si no es ninguno de los anteriores, ocultar los campos de transferencia
            transferenciaInfo.style.display = 'none';
        }
    };

    // Llamar a la función cuando la página cargue para verificar el estado inicial
    actualizarCamposPago();

    // Agregar el evento de cambio para actualizar los campos cuando se seleccione otro método de pago
    paymentMethodSelect.addEventListener('change', actualizarCamposPago);
});





