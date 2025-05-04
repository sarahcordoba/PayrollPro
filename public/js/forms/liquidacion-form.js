// Inicializar años en el selector de año
function initializeYearOptions() {
    const yearSelect = document.getElementById("yearSelect");
    const currentYear = new Date().getFullYear();

    [currentYear - 1, currentYear, currentYear + 1].forEach((year) => {
        const option = document.createElement("option");
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
    });

    yearSelect.value = currentYear; // Seleccionar el año actual por defecto
    updatePeriodOptions();
}

// Generar periodos en el selector de periodos
function updatePeriodOptions() {
    const year = document.getElementById("yearSelect").value;
    const periodSelect = document.getElementById("periodSelect");
    periodSelect.innerHTML = ""; // Limpiar periodos anteriores

    const months = [
        "01/01",
        "02/01",
        "03/01",
        "04/01",
        "05/01",
        "06/01",
        "07/01",
        "08/01",
        "09/01",
        "10/01",
        "11/01",
        "12/01",
    ];

    months.forEach((start, index) => {
        const end = new Date(year, index + 1, 0)
            .toISOString()
            .split("T")[0]
            .split("-")
            .slice(1)
            .join("/"); // Ultimo día del mes
        const option = document.createElement("option");
        option.value = `${start}/${year} - ${end}/${year}`;
        option.textContent = `${start}/${year} - ${end}/${year}`;
        periodSelect.appendChild(option);
    });
}

// Función para crear la liquidación
function crearPeriodo() {
    const period = document.getElementById("periodSelect").value;
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    const liquidacionData = {
        periodo: period,
        estado: "por liquidar",
        salario: 0,
        total_deducciones: 0,
        total_comisiones: 0,
        total: 0,
    };

    fetch("/api/add/liquidacion", {
        // Asegúrate de que esta ruta esté configurada en Laravel
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken, // Agregar el token CSRF aquí
        },
        body: JSON.stringify(liquidacionData),
    })
        .then((response) => {
            if (!response.ok)
                throw new Error("Error en la respuesta del servidor");
            return response.json();
        })
        .then((data) => {
            console.log("Liquidación creada:", data);
            const modal = bootstrap.Modal.getInstance(
                document.getElementById("liquidacionModal")
            );
            modal.hide();

            // Redirigir a la página de detalles de la liquidación creada
            window.location.href = `/liquidaciones/${data.id}`;
        })
        .catch((error) => {
            console.error("Error al crear la liquidación:", error);
        });
}

// Inicializar el formulario con años y periodos
initializeYearOptions();
