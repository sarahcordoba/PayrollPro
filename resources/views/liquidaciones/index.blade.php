@extends('layouts.app')

@section('title', 'Liquidaciones')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- <div class="container-liquidaciones">
  <h1 class="titulito">Liquidaciones</h1>
  <div class="titlebutton">
    <p>Calcula los devengados y deducciones de las personas que integran tu equipo de trabajo</p>
    <!-- Botón para abrir el modal -->
    <button type="button" class="btn btn-primary btn-style" data-bs-toggle="modal" data-bs-target="#liquidacionModal">
      + Nuevo periodo
    </button>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">Periodo</th>
        <th scope="col">Salarios</th>
        <th scope="col">Deducciones</th>
        <th scope="col">Comisiones</th>
        <th scope="col">Total</th>
        <th scope="col">Accion</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($liquidaciones as $liquidacion)
      <tr>
        <th scope="row">{{ \Carbon\Carbon::parse($liquidacion->fecha_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($liquidacion->fecha_fin)->format('d/m/Y') }}</th>
<td>{{ number_format($liquidacion->salario, 2) }}</td>
<td>{{ number_format($liquidacion->total_deducciones, 2) }}</td>
<td>{{ number_format($liquidacion->total_comisiones, 2) }}</td>
<td>{{ number_format($liquidacion->total, 2) }}</td>
<td>
    <a href="{{ route('liquidaciones.show', $liquidacion->id) }}" class="btn btn-secondary">Ir a Liquidar</a>
    <form action="{{ route('liquidaciones.destroy', $liquidacion->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Eliminar</button>
    </form>
</td>
</tr>
@endforeach
</tbody>
</table>

</div> --}}

<div class="container-index-liquidaciones">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="lefte-div">
            <h1>Liquidaciones </h1>
        </div>
        <button type="button" class="btn btn-primary btn-style" data-bs-toggle="modal" data-bs-target="#liquidacionModal">
            + Nuevo periodo
        </button>
    </div>
    <div class="mede-div">
        <p>Calcula los devengados y deducciones de las personas que integran tu equipo de trabajo</p>
    </div>

    <div class="body-liquidaciones">
        <div class="liquidacion-body">
            <input type="text" id="search-input" class="form-control mb-3"
                placeholder="Buscar por salario, deducciones o comisiones">

            <table class="table table-hover table-bordered table-responsive tabla-empleados">
                <thead>
                    <tr>
                        <th scope="col">Periodo</th>
                        <th scope="col">Salarios</th>
                        <th scope="col">Deducciones</th>
                        <th scope="col">Comisiones</th>
                        <th scope="col">Total</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody class="deduccion-tbody">
                    @foreach ($liquidaciones as $liquidacion)
                    <tr>
                        <th scope="row">{{ \Carbon\Carbon::parse($liquidacion->fecha_inicio)->format('d/m/Y') }}
                            - {{ \Carbon\Carbon::parse($liquidacion->fecha_fin)->format('d/m/Y') }}</th>
                        <td>{{ number_format($liquidacion->salario, 2) }}</td>
                        <td>{{ number_format($liquidacion->total_deducciones, 2) }}</td>
                        <td>{{ number_format($liquidacion->total_comisiones, 2) }}</td>
                        <td>{{ number_format($liquidacion->total, 2) }}</td>
                        <td>
                            <a href="{{ route('liquidaciones.show', $liquidacion->id) }}"
                                class="btn btn-secondary btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form action="{{ route('liquidaciones.destroy', $liquidacion->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i
                                        class="bi bi-trash"></i></button>
                            </form>

                        </td>




                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="liquidacionModal" tabindex="-1" aria-labelledby="liquidacionModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="liquidacionModalLabel">Nuevo Periodo de Liquidación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Selecciona el periodo de la nómina a liquidar:</p>

                <div class="mb-3">
                    <label for="yearSelect" class="form-label">Año</label>
                    <select class="form-select" id="yearSelect" onchange="updatePeriodOptions()">
                        <!-- Años dinámicos -->
                    </select>
                </div>

                <div class="mb-3">
                    <label for="periodSelect" class="form-label">Periodo</label>
                    <select class="form-select" id="periodSelect">
                        <!-- Periodos dinámicos -->
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-style" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-style" onclick="crearPeriodo()">Crear Periodo</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Inicializar años en el selector de año
    function initializeYearOptions() {
        const yearSelect = document.getElementById("yearSelect");
        const currentYear = new Date().getFullYear();

        [currentYear - 1, currentYear, currentYear + 1].forEach(year => {
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

        const monthNames = [
            "01", "02", "03", "04", "05", "06",
            "07", "08", "09", "10", "11", "12"
        ];

        monthNames.forEach((month, index) => {
            const start = `01/${month}/${year}`;
            const lastDay = new Date(year, index + 1, 0).getDate(); // Último día del mes
            const end = `${lastDay}/${month}/${year}`;
            const option = document.createElement("option");
            option.value = `${start} - ${end}`;
            option.textContent = `${start} - ${end}`;
            periodSelect.appendChild(option);
        });
    }

    function showToast(message) {
        const toastMessage = document.getElementById('toastMessage');
        toastMessage.textContent = message;

        const toastElement = new bootstrap.Toast(document.getElementById('liveToast'));
        toastElement.show();
    }

    // Función para crear la liquidación
    function crearPeriodo() {
        const period = document.getElementById("periodSelect").value;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Suponiendo que 'period' tiene el formato "DD/MM/YYYY - DD/MM/YYYY"
        const [fecha_inicio, fecha_fin] = period.split(" - ").map(dateStr => {
            const [day, month, year] = dateStr.split("/");
            return `${year}-${month}-${day}`; // Formato "YYYY-MM-DD" para compatibilidad con la base de datos
        });

        const liquidacionData = {
            fecha_inicio: fecha_inicio,
            fecha_fin: fecha_fin,
            estado: "Por liquidar",
            salario: 0,
            progreso: 0,
            total_deducciones: 0,
            total_comisiones: 0,
            total: 0
        };

        console.log(liquidacionData);

        fetch('/api/add/liquidacion', { // Asegúrate de que esta ruta esté configurada en Laravel
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Agregar el token CSRF aquí
                },
                body: JSON.stringify(liquidacionData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // Aquí podría lanzarse el error si el contenido no es JSON
            })
            .then(data => {
                showToast('Periodo de liquidacion creado');
                console.log('Liquidación creada:', data);
                const modal = bootstrap.Modal.getInstance(document.getElementById('liquidacionModal'));
                modal.hide();
                // Redirigir a la página de detalles de la liquidación creada
                window.location.href = `/liquidaciones/${data.id}`;
            })
            .catch(error => {
                console.error('Error al crear la liquidación:', error);
            });
    }

    // Inicializar el formulario con años y periodos
    initializeYearOptions();
</script>

@endsection
<script type="text/javascript" src="{{ asset('js/forms/empleado-form.js') }}"></script>