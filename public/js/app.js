// función para mostrar barra
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('open');
}

// funcion modo oscuro
function toggleMode() {
    const body = document.body;
    const button = document.getElementById("modeToggle");

    // alterna la clase 'dark-mode' en el body
    body.classList.toggle("dark-mode");

    // verifica el estado y actualizar el almacenamiento y el botón
    if (body.classList.contains('dark-mode')) {
        localStorage.setItem('darkMode', 'enabled');
        button.innerHTML = "☀️ Modo Claro";  // cambia el texto
    } else {
        localStorage.setItem('darkMode', 'disabled');
        button.innerHTML = "🌙 Modo Oscuro";  // cambia text
    }
}

// aplicar el modo oscuro al cargar la página si está habilitado en localStorage
window.addEventListener('DOMContentLoaded', () => {
    const darkMode = localStorage.getItem('darkMode');
    const button = document.getElementById("modeToggle");

    if (darkMode === 'enabled') {
        document.body.classList.add('dark-mode');
        button.innerHTML = "☀️ Modo Claro";  // muestra modo claro
    } else {
        button.innerHTML = "🌙 Modo Oscuro";  // muestra modooscuro
    }
});

// agregar el evento de clic al botón de modo oscuro
// document.getElementById('modeToggle').addEventListener('click', toggleMode);

// mensajes
function showToast(message) {
    const toastMessage = document.getElementById('toastMessage');
    toastMessage.textContent = message;

    const toastElement = new bootstrap.Toast(document.getElementById('liveToast'));
    toastElement.show();
}

class FilterableDropdown {
    constructor(container, optionsData) {
        this.container = container;
        this.optionsData = optionsData;
        this.buildDropdown();
        this.attachEvents();
    }

    buildDropdown() {
        // Construir el HTML del input y opciones
        this.input = document.createElement('input');
        this.input.type = 'text';
        this.input.classList.add('form-control', 'dropdown-input');
        this.input.placeholder = '';

        this.icon = document.createElement('span');
        this.icon.classList.add('dropdown-icon');
        this.icon.textContent = '▼';

        this.optionsContainer = document.createElement('div');
        this.optionsContainer.classList.add('options', 'rounded', 'shadow-sm');

        // Aquí modificamos la creación de las opciones
        this.optionsData.forEach(option => {
            const optionElement = document.createElement('div');
            optionElement.classList.add('option');

            // Si el JSON tiene MUNICIPIO y DEPARTAMENTO
            if (option.MUNICIPIO && option.DEPARTAMENTO) {
                optionElement.textContent = `${option.MUNICIPIO}, ${option.DEPARTAMENTO}`;
            }

            // Si el JSON tiene id y description
            if (option.id && option.description) {
                optionElement.textContent = `${option.description}`;
            }

            // Usamos una función de flecha para que `option` se pase correctamente
            optionElement.onclick = () => {
                this.selectOption(option); // Pasamos el objeto `option` completo
                console.log(`Opción seleccionada: ${option.description}`);
            };

            this.optionsContainer.appendChild(optionElement);
        });

        this.noResults = document.createElement('div');
        this.noResults.classList.add('no-results');
        this.noResults.style.display = 'none';
        this.noResults.textContent = 'No se encontró';

        this.optionsContainer.appendChild(this.noResults);
        this.container.appendChild(this.input);
        this.container.appendChild(this.icon);
        this.container.appendChild(this.optionsContainer);
    }

    attachEvents() {
        this.input.addEventListener('input', () => this.filterOptions());
        this.icon.addEventListener('click', () => this.toggleOptions());

        document.addEventListener('click', (event) => {
            if (!this.container.contains(event.target)) {
                this.closeOptions();
            }
        });
    }

    toggleOptions() {
        const isOpen = this.optionsContainer.style.display === 'block';
        this.optionsContainer.style.display = isOpen ? 'none' : 'block';
        this.icon.textContent = isOpen ? '▼' : '▲';
    }

    closeOptions() {
        this.optionsContainer.style.display = 'none';
        this.icon.textContent = '▼';
    }

    filterOptions() {
        const filter = this.normalizeString(this.input.value);
        let hasVisibleOption = false;

        Array.from(this.optionsContainer.getElementsByClassName('option')).forEach(option => {
            const optionText = this.normalizeString(option.innerText);
            if (optionText.includes(filter)) {
                option.style.display = 'block';
                hasVisibleOption = true;
            } else {
                option.style.display = 'none';
            }
        });

        this.noResults.style.display = hasVisibleOption ? 'none' : 'block';
        this.optionsContainer.style.display = 'block';
        this.icon.textContent = '▲';
    }

    selectOption(option) {
        // Actualizar el campo de entrada con la descripción de la opción
        this.input.value = option.description;
        this.closeOptions();

        // Aquí es donde se agrega la lógica de verificación del salario
        const salarioInput = document.getElementById("salario");
        const tiposConSalarioCero = [12, 19, 21, 42]; // Tipos de cotizantes con salario cero

        // Llamar a la función de verificación con los valores correctos
        if (option.id !== undefined && salarioInput) {
            verificarSalario(tiposConSalarioCero, option.id, salarioInput);
        } else {
            console.error("ID o salario no definidos correctamente");
        }
    }

    normalizeString(str) {
        return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
    }
}

function verificarSalario(tiposConSalarioCero, tipoCotizanteId, salarioInput) {
    const salario = parseFloat(salarioInput.value); // Valor del salario ingresado

    // Verificamos si el tipo de cotizante tiene salario 0 y el salario no es 0
    if (salarioInput.value !== "" && tiposConSalarioCero.includes(tipoCotizanteId) && salario !== 0) {
        showToast('¡Error! Los cotizantes de este tipo deben tener un salario de 0.');
        salarioInput.value = ''; // Limpiar el salario si es incorrecto
    }
}

async function loadDropdownData(id) {
    console.log("Cargando datos para:", id);
    try {
        const response = await fetch(`/data/${id}.json`);
        const optionsData = await response.json();

        // Verifica que los datos se cargan correctamente
        console.log("Datos cargados:", optionsData);

        const container = document.getElementById(id);
        if (container) {
            new FilterableDropdown(container, optionsData);
        }
    } catch (error) {
        console.error("Error al cargar los datos:", error);
    }
}

// Llamar a la carga de datos de los dropdowns
// loadDropdownData('municipios');
// loadDropdownData('tipo_cotizacion');




