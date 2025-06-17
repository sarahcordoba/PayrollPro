@extends('layouts.app')

@section('title', 'Detalles Liquidación')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container-liquidaciones">
    <h1>Detalles de la Liquidación</h1>

    <div class="container-container">
        <div class="container-left">
            <div class="card sb-light shadow " style="height: 6rem">
                <div class="card-body text-center">
                    <p><strong> Progreso</strong> {{ $liquidacion->progreso }}%</p>

                </div>
            </div>
        </div>
        <div class="container-right">
            <div class="card sb-light shadow r" style="height: 6rem">
                <ul class="list-group list-group-flush sb-light">
                    <li class="list-group-item"><strong>Periodo de liquidacion:</strong> {{ $liquidacion->fecha_inicio }} - {{ $liquidacion->fecha_fin }}</li>
                    <li class="list-group-item"><strong>Estado:</strong> {{ $liquidacion->estado }}</li>
                </ul>
            </div>
        </div>
    </div>


    <div class="card sb-light shadow" style="width: 100%;">
        <ul class="list-group list-group-horizontal list-group-flush sb-light">
            <li class="list-group-item d-flex flex-column">
                <strong>Empleados</strong>
                <span>{{ count($nominas)}}</span>
            </li>
            <li class="list-group-item d-flex flex-column">
                <strong>Salario:</strong> ${{ number_format($liquidacion->salario,2) }}
            </li>
            <li class="list-group-item d-flex flex-column">
                <strong>Total deducciones:</strong> ${{ number_format($liquidacion->total_deducciones,2) }}
            </li>
            <li class="list-group-item d-flex flex-column">
                <strong>Total comisiones:</strong> ${{ number_format($liquidacion->total_comisiones,2) }}
            </li>
            <li class="list-group-item d-flex flex-column">
                <strong>Total:</strong> ${{ number_format($liquidacion->total,2) }}
            </li>
        </ul>
    </div>
    <div class="container-empleados-liquidaciones">
        <h1 class="titulito">Empleados</h1>
        <div class="titlebutton">
            <div class="text-empleads">
                <p>Gestiona la información de tus empleados/as que vas a tener en cuenta para liquidar la nómina de este período.</p>
            </div>
            <div class="boton-empleads">
                <button type="button" class="btn btn-primary btn-style" data-bs-toggle="modal" data-bs-target="#liquidacionModal" data-liquidacion-id="{{ $liquidacion->id }}">
                    + Agregar empleado
                </button>
            </div>
        </div>
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <table class="table table table-hover table-bordered table-responsive">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Id</th>
                    <th scope="col">Salarios</th>
                    <th scope="col">Deducciones</th>
                    <th scope="col">Comisiones</th>
                    <th scope="col">Total</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody id="tbody-nominas">
                @foreach($nominas as $nomina)
                <tr>
                    <td>{{ $nomina->empleado->primer_nombre}} {{ $nomina->empleado->segundo_nombre}} {{ $nomina->empleado->primer_apellido}} {{ $nomina->empleado->segundo_apellido}}</td> <!-- Asumiendo que Nomina tiene relación con Empleado -->
                    <td>{{ $nomina->id }}</td>
                    <td>${{ number_format($nomina->salario_base, 2) }}</td>
                    <td>${{ number_format($nomina->total_deducciones, 2) }}</td>
                    <td>${{ number_format($nomina->total_comisiones, 2) }}</td>
                    <td>${{ number_format($nomina->total, 2) }}</td>
                    <td>
                        <a href="{{ route('nominas.show', ['nomina' => $nomina->id, 'fromIndex' => true]) }}" class="btn btn-secondary btn-style">Ver Detalles</a>
                        @if ($nomina->estado != 'Liquidado')
                        <a href="{{ route('nominas.edit', $nomina->id) }}" class="btn btn-secondary btn-style">Editar</a>
                        <button class="btn btn-primary btn-style" data-bs-toggle="modal" data-bs-target="#modalLiquidar">
                            Liquidar
                        </button>

                        @endif
                        <form id="formEliminarNomina{{ $nomina->id }}" action="{{ route('nominas.destroy', $nomina->id) }}" method="POST" class="form-eliminar-nomina">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-style"><i class="bi bi-trash"></i></button>
                        </form>

    </div>
    </td>
    </tr>
    @endforeach
    </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="liquidacionModal" tabindex="-1" aria-labelledby="liquidacionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="liquidacionModalLabel">Agregar empleados a la liquidación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p>Selecciona los empleados que deseas agregar a esta liquidación.</p>

                <!-- Tabla de empleados -->
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"><input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)"></th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Salario</th>
                            <th scope="col">Identificación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($empleados as $empleado)
                        <tr>
                            <td><input type="checkbox" class="employee-checkbox" value="{{ $empleado->id }}"></td>
                            <td>{{ $empleado->primer_nombre }} {{ $empleado->segundo_nombre }} {{ $empleado->primer_apellido }} {{ $empleado->segundo }}</td>
                            <td>{{ number_format($empleado->salario, 2) }}</td>
                            <td>{{ $empleado->numero_identificacion }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-style" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-style" onclick="crearNominas()">Crear</button>
            </div>
        </div>
    </div>
</div>

@isset($nomina)
<!-- Modal Liquidar -->
<div class="modal fade" id="modalLiquidar" tabindex="-1" aria-labelledby="modalLiquidarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('nominas.liquidar', $nomina->id) }}">
            @csrf
            @method('PUT') <!-- or POST depending on your route definition -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLiquidarLabel">Liquidar Nómina</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <label for="paymentOption" class="form-label">Método de pago</label>
                    <select name="paymentOption" id="paymentOption" class="form-select" required>
                        <option value="">-- Seleccione una opción --</option>
                        <option value="pago_efectivo" {{ $nomina->empleado->metodo_pago == 'pago_efectivo' ? 'selected' : '' }}>Pago en efectivo {{ $nomina->empleado->metodo_pago == 'pago_efectivo' ? '(Seleccion del cliente)' : '' }}</option>
                        <option value="transferencia" {{ $nomina->empleado->metodo_pago == 'transferencia' ? 'selected' : '' }}>Transferencia bancaria {{ $nomina->empleado->metodo_pago == 'transferencia' ? '(Seleccion del cliente)' : '' }}</option>
                        <option value="cheque_bancario" {{ $nomina->empleado->metodo_pago == 'cheque_bancario' ? 'selected' : '' }}>Cheque bancario {{ $nomina->empleado->metodo_pago == 'cheque_bancario' ? '(Seleccion del cliente)' : '' }}</option>
                        <option value="pago_especie" {{ $nomina->empleado->metodo_pago == 'pago_especie' ? 'selected' : '' }}>Pago en especie (bonos o vales) {{ $nomina->empleado->metodo_pago == 'pago_especie' ? '(Seleccion del cliente)' : '' }}</option>
                    </select>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-style" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-style">Confirmar Liquidación</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endisset
<script>
    // Función para seleccionar o deseleccionar todos los checkboxes
    function toggleSelectAll(source) {
        const checkboxes = document.querySelectorAll('.employee-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = source.checked;
        });
    }

    function showToast(message, type = 'success') {
        const toast = document.getElementById('liveToast');
        const toastMessage = document.getElementById('toastMessage');

        // Limpia clases previas de color
        toast.classList.remove('bg-success', 'bg-danger', 'bg-warning', 'bg-info');

        // Aplica clase según el tipo
        const typeClassMap = {
            success: 'bg-success',
            error: 'bg-danger',
            warning: 'bg-warning',
            info: 'bg-info'
        };

        toast.classList.add(typeClassMap[type] || 'bg-success');

        // Mensaje y mostrar
        toastMessage.textContent = message;
        const toastElement = new bootstrap.Toast(toast);
        toastElement.show();
    }


    // Función para manejar la creación de las nóminas seleccionadas
    function crearNominas() {
        const selectedEmployees = [];
        document.querySelectorAll('.employee-checkbox:checked').forEach(checkbox => {
            selectedEmployees.push(checkbox.value);
        });

        if (selectedEmployees.length === 0) {
            alert("Por favor selecciona al menos un empleado.");
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const idLiquidacion = document.querySelector('[data-bs-target="#liquidacionModal"]').getAttribute('data-liquidacion-id');

        let completed = 0;
        const total = selectedEmployees.length;

        selectedEmployees.forEach((employee) => {
            fetch('/api/add/nomina', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        empleado_id: employee,
                        idLiquidacion: idLiquidacion
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Insertar nueva fila en la tabla
                    const tbody = document.getElementById('tbody-nominas');
                    const tr = document.createElement('tr');

                    const nombreCompleto = `${data.empleado.primer_nombre} ${data.empleado.segundo_nombre || ''} ${data.empleado.primer_apellido} ${data.empleado.segundo_apellido || ''}`.trim();

                    tr.innerHTML = `
                <td>${nombreCompleto}</td>
                <td>${data.id}</td>
                <td>$${Number(data.salario_base).toLocaleString('es-CO', { minimumFractionDigits: 2 })}</td>
                <td>$${Number(data.total_deducciones).toLocaleString('es-CO', { minimumFractionDigits: 2 })}</td>
                <td>$${Number(data.total_comisiones).toLocaleString('es-CO', { minimumFractionDigits: 2 })}</td>
                <td>$${Number(data.total).toLocaleString('es-CO', { minimumFractionDigits: 2 })}</td>
                <td>
                    <a href="/nominas/${data.id}" class="btn btn-secondary btn-style">Ver Detalles</a>
                    <a href="/nominas/${data.id}/edit" class="btn btn-secondary btn-style">Editar</a>
                    <a href="/nominas/${data.id}" class="btn btn-secondary btn-style">Liquidar</a>
                    <form id="formEliminarNomina${data.id}" action="/nominas/${data.id}" method="POST" class="form-eliminar-nomina">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger btn-style"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            `;

                    tbody.appendChild(tr);

                    completed++;
                    if (completed === total) {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('liquidacionModal'));
                        modal.hide();
                        showToast("Nóminas creadas exitosamente.");

                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }

                    bindEliminarNominas();

                })
                .catch(error => {
                    showToast("Error al crear la nómina:", 'error');
                    console.error("Error al crear la nómina:", error);
                });
        });
    }


    function bindEliminarNominas() {
        document.querySelectorAll('.form-eliminar-nomina').forEach(form => {
            form.onsubmit = function(e) {
                e.preventDefault();
                if (!confirm('¿Estás seguro de que deseas eliminar esta nómina?')) return;

                const url = this.action;
                const csrf = this.querySelector('input[name="_token"]').value;

                fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            this.closest('tr').remove();
                            showToast("Nómina eliminada correctamente.");

                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            showToast('Ocurrió un error al eliminar la nómina.', 'error');
                        }
                    })
                    .catch(() => showToast('Error de red al intentar eliminar la nómina.', 'error'));
            };
        });
    }

    bindEliminarNominas();
</script>
@endsection