@extends('layouts.app')

@section('title', 'Lq')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
    <h1>Detalles de la Liquidación</h1>

    <div class="card" style="width: 100%; height: fit-content">
        <div class="card-body text-center">
            <p style="font-size:xx-large"><strong> Colilla de pago</strong></p>
            <p style="font-size:x-large"><strong>Resumen del Pago</strong></p>

            <div class="card">
                <style>
                    p {
                        margin-bottom: 0;
                    }
                </style>
                <p>datos de la empresa</p>
                <p>nit</p>
                <p>direccion</p>
                <p>correo</p>
            </div>
            <div class="card">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Empleado:</strong> {{ $nomina->empleado->primer_nombre }}
                        {{ $nomina->empleado->segundo_nombre }} {{ $nomina->empleado->primer_apellido }}
                        {{ $nomina->empleado->segundo_apellido }}
                    </li>
                    <li class="list-group-item"><strong>Identificacion:</strong> {{ $nomina->empleado->id }}</li>
                    <li class="list-group-item"><strong>Periodo de liquidacion:</strong>
                        {{ $nomina->liquidacion->fecha_inicio }} - {{ $nomina->liquidacion->fecha_fin }}
                    </li>
                    <li class="list-group-item"><strong>Estado:</strong> {{ $nomina->estado }}</li>
                </ul>
            </div>
            <div class="card">
                <ul class="list-group list-group-horizontal list-group-flush">
                    <li class="list-group-item d-flex flex-column">
                        <strong>Salario:</strong> ${{ number_format($nomina->salario_base, 2) }}
                    </li>
                    <li class="list-group-item d-flex flex-column">
                        <strong>Total deducciones:</strong> ${{ number_format($nomina->total_deducciones, 2) }}
                    </li>
                    <li class="list-group-item d-flex flex-column">
                        <strong>Total comisiones:</strong> ${{ number_format($nomina->total_comisiones, 2) }}
                    </li>
                    <li class="list-group-item d-flex flex-column">
                        <strong>Total:</strong> ${{ number_format($nomina->total, 2) }}
                    </li>
                </ul>
            </div>

            <p style="font-size:x-large"><strong>Comisiones</strong></p>

            <!-- Botón para abrir el modal de añadir comisiones -->
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalComision">
                Añadir Comisión
            </button>

            <div class="card">
                <ul class="list-group">
                    @foreach ($comisionesAplicadas as $comisiona)
                    <ul class="list-group list-group-horizontal list-group-flush">
                        <li class="list-group-item d-flex flex-column">
                            <strong>Tipo</strong> {{ $comisiona->comision->tipo }}
                        </li>
                        <li class="list-group-item d-flex flex-column">
                            <strong>Descripción</strong> {{ $comisiona->comision->descripcion }}
                        </li>
                        <li class="list-group-item d-flex flex-column">
                            <strong>Porcentaje</strong>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"
                                    id="isPercentage-{{ $comisiona->comision_id }}"
                                    name="esporcentaje[{{ $comisiona->comision_id }}]" value="1"
                                    {{ $comisiona->esporcentaje ? 'checked' : '' }}
                                    @if (in_array($comisiona->comision_id, [1])) disabled @endif>
                                <label class="form-check-label" for="isPercentage-{{ $comisiona->comision_id }}">
                                    ¿Es porcentaje?
                                </label>
                            </div>

                            <input type="number" step="0.01" class="form-control mt-2"
                                id="percentageInput-{{ $comisiona->comision_id }}" name="porcentaje[{{ $comisiona->comision_id }}]"
                                value="{{ $comisiona->esporcentaje ? $comisiona->monto * 100: '' }}"
                                placeholder="Porcentaje (%)" @if (!$comisiona->esporcentaje || in_array($comisiona->comision_id, [1])) disabled @endif>
                        </li>

                        <li class="list-group-item d-flex flex-column">
                            <strong>Monto</strong>
                            <input type="number" step="0.01" class="form-control mt-2"
                                id="amountInput-{{ $comisiona->comision_id }}" name="monto[{{ $comisiona->comision_id }}]"
                                value="{{ !$comisiona->esporcentaje ? $comisiona->monto : '' }}"
                                placeholder="Monto ($)" @if ($comisiona->esporcentaje || in_array($comisiona->comision_id, [1])) disabled @endif>
                        </li>

                        <li class="list-group-item d-flex flex-column">
                            <!-- DELETE FORM -->
                            <form id="delete-comision-{{ $comisiona->comision_id }}"
                                action="{{ route('comisionnomina.delete', [$comisiona->nomina_id, $comisiona->comision_id]) }}"
                                method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-secondary"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta comisión?');">
                                    X
                                </button>
                            </form>
                            <button type="button" class="btn btn-primary"
                                @if (in_array($comisiona->comision_id, [1])) disabled @endif
                                onclick="editComision({{ $comisiona->comision_id }}, {{ $nomina->id }})">
                                <i class="bi bi-floppy"></i>
                            </button>

                        </li>
                    </ul>
                    @endforeach
                </ul>
            </div>

            <p style="font-size:x-large"><strong>Deducciones</strong></p>
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalDeduccion">
                Añadir Deducción
            </button>
            <div class="card">
                <ul class="list-group">
                    @foreach ($deduccionesAplicadas as $deducciona)
                    <ul class="list-group list-group-horizontal list-group-flush">
                        <li class="list-group-item d-flex flex-column">
                            <strong>Tipo</strong> {{ $deducciona->deduccion->tipo }}
                        </li>
                        <li class="list-group-item d-flex flex-column">
                            <strong>Descripción</strong> {{ $deducciona->deduccion->descripcion }}
                        </li>
                        <li class="list-group-item d-flex flex-column">
                            <strong>Porcentaje</strong>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"
                                    id="isPercentaged-{{ $deducciona->deduccion_id}}"
                                    name="esporcentajed[{{ $deducciona->deduccion_id}}]" value="1"
                                    {{ $deducciona->esporcentaje ? 'checked' : '' }}
                                    @if (in_array($deducciona->deduccion_id, [1, 2, 3])) disabled @endif>
                                <label class="form-check-label" for="isPercentage-{{ $deducciona->deduccion_id}}">
                                    ¿Es porcentaje?
                                </label>
                            </div>

                            <input type="number" step="0.01" class="form-control mt-2"
                                id="percentageInputd-{{ $deducciona->deduccion_id}}"
                                name="porcentaje[{{ $deducciona->deduccion_id}}]"
                                value="{{ $deducciona->esporcentaje ? $deducciona->monto * 100: '' }}"
                                placeholder="Porcentaje (%)" @if (!$deducciona->esporcentaje || in_array($deducciona->deduccion_id, [1, 2, 3])) disabled @endif>
                        </li>

                        <li class="list-group-item d-flex flex-column">
                            <strong>Monto</strong>
                            <input type="number" step="0.01" class="form-control mt-2"
                                id="amountInputd-{{ $deducciona->deduccion_id}}" name="monto[{{ $deducciona->deduccion_id}}]"
                                value="{{ !$deducciona->esporcentaje ? $deducciona->monto : '' }}"
                                placeholder="Monto ($)" @if ($deducciona->esporcentaje || in_array($deducciona->deduccion_id, [1, 2, 3])) disabled @endif>
                        </li>
                        <li class="list-group-item d-flex flex-column">
                            <form id="delete-deduccion-{{ $deducciona->deduccion_id }}"
                                action="{{ route('deduccionnomina.delete', [$deducciona->nomina_id, $deducciona->deduccion_id]) }}"
                                method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-secondary"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta deducción?');">
                                    X
                                </button>
                            </form>
                            <button type="button" class="btn btn-primary"
                                @if (in_array($deducciona->deduccion_id, [1])) disabled @endif
                                onclick="editDeduccion({{ $deducciona->deduccion_id }}, {{ $nomina->id }})">
                                <i class="bi bi-floppy"></i>
                            </button>
                        </li>
                    </ul>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div style="display:flex; justify-content: space-between;">
        <a href="{{ route('nominas.show', $nomina->id) }}" class="btn btn-secondary">Cancelar</a>
        <div style="display:flex; gap: .5rem;">
            <a href="{{ route('nominas.edit', $nomina->id) }}" class="btn btn-primary">Guardar</a>
        </div>
    </div>
</div>

<!-- Modal para añadir comisión -->
<div class="modal fade" id="modalComision" tabindex="-1" aria-labelledby="modalComisionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalComisionLabel">Añadir Comisión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="selectComision" class="form-label">Seleccionar Comisión</label>
                    <select id="selectComision" class="form-select">
                        <option value="">-- Seleccionar --</option>
                        @foreach ($comisionesDisponibles as $comision)
                        <option value="{{ $comision->id }}" data-esporcentaje="{{ $comision->esporcentaje }}"
                            data-monto="{{ $comision->monto }}">
                            {{ $comision->descripcion }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="checkboxComisionPorcentaje">
                    <label class="form-check-label" for="checkboxComisionPorcentaje">¿Es porcentaje?</label>
                </div>
                <div class="mb-3">
                    <label for="inputComisionMonto" class="form-label">Monto</label>
                    <input type="number" step="0.01" id="inputComisionMonto" class="form-control">
                </div>
                <button id="btnGuardarComision" class="btn btn-primary">Guardar Comisión</button>
                <button id="btnNuevaComision" class="btn btn-link">Crear Nueva Comisión</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para nueva comisión -->
<div class="modal fade" id="modalNuevaComision" tabindex="-1" aria-labelledby="modalNuevaComisionLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNuevaComisionLabel">Crear Nueva Comisión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="inputComisionTipo" class="form-label">Tipo</label>
                    <input type="text" id="inputComisionTipo" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="inputComisionDescripcion" class="form-label">Descripción</label>
                    <input type="text" id="inputComisionDescripcion" class="form-control">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="checkboxNuevaComisionPorcentaje">
                    <label class="form-check-label" for="checkboxNuevaComisionPorcentaje">¿Es porcentaje?</label>
                </div>
                <div class="mb-3">
                    <label for="inputNuevaComisionMonto" class="form-label">Monto</label>
                    <input type="number" step="0.01" id="inputNuevaComisionMonto" class="form-control">
                </div>
                <button id="btnGuardarNuevaComision" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para deducción -->
<div class="modal fade" id="modalDeduccion" tabindex="-1" aria-labelledby="modalDeduccionLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeduccionLabel">Añadir Deducción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="selectDeduccion" class="form-label">Seleccionar Deducción</label>
                    <select id="selectDeduccion" class="form-select">
                        <option value="">-- Seleccionar --</option>
                        @foreach ($deduccionesDisponibles as $deduccion)
                        <option value="{{ $deduccion->id }}" data-esporcentaje="{{ $deduccion->esporcentaje }}"
                            data-monto="{{ $deduccion->monto }}">
                            {{ $deduccion->descripcion }}

                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="checkboxPorcentaje">
                    <label class="form-check-label" for="checkboxPorcentaje">¿Es porcentaje?</label>
                </div>
                <div class="mb-3">
                    <label for="inputMonto" class="form-label">Monto</label>
                    <input type="number" step="0.01" id="inputMonto" class="form-control">
                </div>
                <button id="btnGuardarDeduccion" class="btn btn-primary">Guardar Deducción</button>
                <button id="btnNuevaDeduccion" class="btn btn-link">Crear Nueva Deducción</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para nueva deducción -->
<div class="modal fade" id="modalNuevaDeduccion" tabindex="-1" aria-labelledby="modalNuevaDeduccionLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNuevaDeduccionLabel">Crear Nueva Deducción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="inputTipo" class="form-label">Tipo</label>
                    <input type="text" id="inputTipo" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="inputDescripcion" class="form-label">Descripción</label>
                    <input type="text" id="inputDescripcion" class="form-control">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="checkboxNuevaPorcentaje">
                    <label class="form-check-label" for="checkboxNuevaPorcentaje">¿Es porcentaje?</label>
                </div>
                <div class="mb-3">
                    <label for="inputNuevaMonto" class="form-label">Monto</label>
                    <input type="number" step="0.01" id="inputNuevaMonto" class="form-control">
                </div>
                <button id="btnGuardarNuevaDeduccion" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    // Configuración del token CSRF para las solicitudes
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.addEventListener("DOMContentLoaded", function() {
        // Get all percentage checkboxes
        const percentageCheckboxes = document.querySelectorAll('.form-check-input[id^="isPercentage-"]');
        //const percentagedCheckboxes = document.querySelectorAll('.form-check-input[id^="isPercentaged-"]');

        // Add event listeners to each checkbox
        percentageCheckboxes.forEach(checkbox => {
            checkbox.addEventListener("change", function() {
                const comisionId = this.id.split('-')[1];
                const percentageInput = document.getElementById(`percentageInput-${comisionId}`);
                const amountInput = document.getElementById(`amountInput-${comisionId}`);

                if (this.checked) {
                    // Enable percentage input and disable amount input
                    percentageInput.disabled = false;
                    amountInput.disabled = true;
                    amountInput.value = ''; // Clear the amount input
                } else {
                    // Disable percentage input and enable amount input
                    percentageInput.disabled = true;
                    amountInput.disabled = false;
                    percentageInput.value = ''; // Clear the percentage input
                }
            });
        });
    });

    console.log('Hola');

    function test() {
        console.log('Test');
    }

    function editComision(comisionId, nominaId) {
        console.log('Editando comision');

        const esPorcentaje = document.getElementById(`isPercentage-${comisionId}`).checked ? 1 : 0;
        const percentageI = parseFloat(document.getElementById(`percentageInput-${comisionId}`).value) || 0;
        const monto = parseFloat(document.getElementById(`amountInput-${comisionId}`).value) || 0;

        const finalMonto = esPorcentaje ? (percentageI / 100) : monto;
        // Prepare the data for the API
        const requestData = {
            esporcentaje: esPorcentaje,
            monto: finalMonto
        };
        //return;

        // Send PUT request to the API
        fetch(`/api/update/comisionnomina/${nominaId}/${comisionId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token
                },
                body: JSON.stringify(requestData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error updating the commission.');
                }
                return response.json();
            })
            .then(data => {
                alert('Comisión actualizada con éxito.');
                location.reload(); // Reload the page to reflect changes
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al actualizar la comisión.');
            });
    }



    function sendPostRequest(url, data, onSuccess, onError) {
        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(onSuccess)
            .catch(onError);
    }

    // Actualizar campos al seleccionar una comisión
    document.getElementById('selectComision').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const esPorcentaje = selectedOption.getAttribute('data-esporcentaje') === '1';
        const monto = parseFloat(selectedOption.getAttribute('data-monto')) || 0;

        document.getElementById('checkboxComisionPorcentaje').checked = esPorcentaje;
        document.getElementById('inputComisionMonto').value = esPorcentaje ? monto * 100 : monto;
    });

    // Cambiar monto según "es porcentaje"
    // document.getElementById('checkboxComisionPorcentaje').addEventListener('change', function() {
    //     const monto = parseFloat(document.getElementById('inputComisionMonto').value) || 0;
    //     document.getElementById('inputComisionMonto').value = this.checked ? monto * 100 : monto / 100;
    // });

    // Guardar nueva comisión
    document.getElementById('btnGuardarNuevaComision').addEventListener('click', function() {
        const tipo = document.getElementById('inputComisionTipo').value;
        const descripcion = document.getElementById('inputComisionDescripcion').value;
        const esPorcentaje = document.getElementById('checkboxNuevaComisionPorcentaje').checked ? 1 : 0;
        const monto = parseFloat(document.getElementById('inputNuevaComisionMonto').value) || 0;

        sendPostRequest('/api/add/comisiones', {
            tipo,
            descripcion,
            esporcentaje: esPorcentaje,
            monto
        }, function(response) {
            alert('Nueva comisión creada con éxito.');
            // Insertar automáticamente en comisiones_nomina
            sendPostRequest('/api/add/comisionesnomina', {
                nomina_id: '<?= $nomina->id ?>',
                comision_id: response.id,
                esporcentaje: esPorcentaje,
                monto: esPorcentaje ? (monto / 100) : monto
            }, function() {
                alert('Comisión asignada a la nómina.');
                location.reload();
            });
        }, function() {
            alert('Error al crear la nueva comisión.');
        });
    });

    // Guardar comisión seleccionada
    document.getElementById('btnGuardarComision').addEventListener('click', function() {
        const comisionId = document.getElementById('selectComision').value;
        const esPorcentaje = document.getElementById('checkboxComisionPorcentaje').checked ? 1 : 0;
        const monto = parseFloat(document.getElementById('inputComisionMonto').value) || 0;

        sendPostRequest('/api/add/comisionesnomina', {
            nomina_id: '<?= $nomina->id ?>',
            comision_id: comisionId,
            esporcentaje: esPorcentaje,
            monto: esPorcentaje ? (monto / 100) : monto
        }, function() {
            alert('Comisión guardada con éxito.');
            location.reload();
        }, function() {
            alert('Error al guardar la comisión.');
        });
    });

    // Abrir modal para crear nueva comisión
    document.getElementById('btnNuevaComision').addEventListener('click', function() {
        const modal = new bootstrap.Modal(document.getElementById('modalNuevaComision'));
        modal.show();
    });
</script>
{{-- CODIGO DEDUCCIONES --}}
<script>
    // Configuración del token CSRF para las solicitudes
    // const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    document.addEventListener("DOMContentLoaded", function() {
        // Get all percentage checkboxes
        const percentagedCheckboxes = document.querySelectorAll('.form-check-input[id^="isPercentaged-"]');
        //const percentagedCheckboxes = document.querySelectorAll('.form-check-input[id^="isPercentaged-"]');

        // Add event listeners to each checkbox
        percentagedCheckboxes.forEach(checkbox => {
            checkbox.addEventListener("change", function() {
                const comisionId = this.id.split('-')[1];
                const percentageInput = document.getElementById(`percentageInputd-${comisionId}`);
                const amountInput = document.getElementById(`amountInputd-${comisionId}`);

                if (this.checked) {
                    // Enable percentage input and disable amount input
                    percentageInput.disabled = false;
                    amountInput.disabled = true;
                    amountInput.value = ''; // Clear the amount input
                } else {
                    // Disable percentage input and enable amount input
                    percentageInput.disabled = true;
                    amountInput.disabled = false;
                    percentageInput.value = ''; // Clear the percentage input
                }
            });
        });
    });

    function editDeduccion(deduccionId, nominaId) {
        console.log('Editando deduccion');

        const esPorcentaje = document.getElementById(`isPercentaged-${deduccionId}`).checked ? 1 : 0;
        const percentageI = parseFloat(document.getElementById(`percentageInputd-${deduccionId}`).value) || 0;
        const monto = parseFloat(document.getElementById(`amountInputd-${deduccionId}`).value) || 0;

        const finalMonto = esPorcentaje ? (percentageI / 100) : monto;
        // Prepare the data for the API
        const requestData = {
            esporcentaje: esPorcentaje,
            monto: finalMonto
        };
        //return;

        // Send PUT request to the API
        fetch(`/api/update/deduccionnomina/${nominaId}/${deduccionId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token
                },
                body: JSON.stringify(requestData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error updating the deduccion.');
                }
                return response.json();
            })
            .then(data => {
                alert('deduccion actualizada con éxito.');
                location.reload(); // Reload the page to reflect changes
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al actualizar la deduccion.');
            });
    }



    function sendPostRequest(url, data, onSuccess, onError) {
        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(onSuccess)
            .catch(onError);
    }

    // Actualizar campos al seleccionar una deducción
    document.getElementById('selectDeduccion').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const esPorcentaje = selectedOption.getAttribute('data-esporcentaje') === '1';
        const monto = parseFloat(selectedOption.getAttribute('data-monto')) || 0;

        document.getElementById('checkboxPorcentaje').checked = esPorcentaje;
        document.getElementById('inputMonto').value = esPorcentaje ? monto * 100 : monto;
    });

    // Cambiar monto según "es porcentaje"
    // document.getElementById('checkboxPorcentaje').addEventListener('change', function() {
    //     const monto = parseFloat(document.getElementById('inputMonto').value) || 0;
    //     document.getElementById('inputMonto').value = this.checked ? monto * 100 : monto / 100;
    // });

    // Guardar nueva deducción
    document.getElementById('btnGuardarNuevaDeduccion').addEventListener('click', function() {
        const tipo = document.getElementById('inputTipo').value;
        const descripcion = document.getElementById('inputDescripcion').value;
        const esPorcentaje = document.getElementById('checkboxNuevaPorcentaje').checked ? 1 : 0;
        const monto = parseFloat(document.getElementById('inputNuevaMonto').value) || 0;

        sendPostRequest('/api/add/deducciones', {
            tipo,
            descripcion,
            esporcentaje: esPorcentaje,
            monto
        }, function(response) {
            alert('Nueva deducción creada con éxito.');
            // Insertar automáticamente en deducciones_nomina
            sendPostRequest('/api/add/deduccionesnomina', {
                nomina_id: '<?= $nomina->id ?>',
                deduccion_id: response.id,
                esporcentaje: esPorcentaje,
                monto: esPorcentaje ? (monto / 100) : monto
            }, function() {
                alert('Deducción asignada a la nómina.');
                location.reload();
            });
        }, function() {
            alert('Error al crear la nueva deducción.');
        });
    });

    // Guardar deducción seleccionada
    document.getElementById('btnGuardarDeduccion').addEventListener('click', function() {
        const deduccionId = document.getElementById('selectDeduccion').value;
        const esPorcentaje = document.getElementById('checkboxPorcentaje').checked ? 1 : 0;
        const monto = parseFloat(document.getElementById('inputMonto').value) || 0;

        sendPostRequest('/api/add/deduccionesnomina', {
            nomina_id: '<?= $nomina->id ?>',
            deduccion_id: deduccionId,
            esporcentaje: esPorcentaje,
            monto: esPorcentaje ? (monto / 100) : monto
        }, function() {
            alert('Deducción guardada con éxito.');
            location.reload();
        }, function() {
            alert('Error al guardar la deducción.');
        });
    });

    // Abrir modal para crear nueva deducción
    document.getElementById('btnNuevaDeduccion').addEventListener('click', function() {
        const modal = new bootstrap.Modal(document.getElementById('modalNuevaDeduccion'));
        modal.show();
    });
</script>
@endsection