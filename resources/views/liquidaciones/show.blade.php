@extends('layouts.app')

@section('title', 'Lq')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container-liquidaciones">
    <h1>Detalles de la Liquidación</h1>
    <div class="rowa mt-4" style="display:flex;">
        <div class="col-md-6">
            <div class="card" style="height: 6rem">
                <div class="card-body text-center">
                    <p><strong> Progreso</strong> 10%</p>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card" style="height: 6rem">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Periodo de liquidacion</strong> {{ $liquidacion->fecha_inicio }} - {{ $liquidacion->fecha_fin }}</li>
                    <li class="list-group-item"><strong>Estado:</strong> {{ $liquidacion->estado }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card" style="width: 100%;">
        <ul class="list-group list-group-horizontal list-group-flush">
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
    <div class="container-liquidaciones">
        <h1 class="titulito">Empleados</h1>
        <div class="titlebutton">
            <p>Gestiona la información de tus empleados/as que vas a tener en cuenta para liquidar la nómina de este período.</p>
            <!-- Botón para abrir el modal con el id de liquidación en un atributo data -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#liquidacionModal" data-liquidacion-id="{{ $liquidacion->id }}">
                Agregar empleado
            </button>
        </div>
        <button type="button" class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .6rem;">Filtar
        </button>
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
            <tbody>
                @foreach($nominas as $nomina)
                <tr>
                    <td>{{ $nomina->empleado->primer_nombre}} {{ $nomina->empleado->segundo_nombre}} {{ $nomina->empleado->primer_apellido}} {{ $nomina->empleado->segundo_apellido}}</td> <!-- Asumiendo que Nomina tiene relación con Empleado -->
                    <td>{{ $nomina->id }}</td>
                    <td>${{ number_format($nomina->salario_base, 2) }}</td>
                    <td>${{ number_format($nomina->total_deducciones, 2) }}</td>
                    <td>${{ number_format($nomina->total_comisiones, 2) }}</td>
                    <td>${{ number_format($nomina->total, 2) }}</td>
                    <td>
                        <a href="{{ route('nominas.show', $nomina->id) }}" class="btn btn-secondary">Ver Detalles</a>
                        <a href="{{ route('nominas.edit', $nomina->id) }}" class="btn btn-secondary">Editar</a>
                        <a href="{{ route('nominas.show', $nomina->id) }}" class="btn btn-secondary">Liquidar</a>
                        <form action="{{ route('nominas.destroy', $nomina->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
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
                                <td>{{ $empleado->identificacion }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="crearNominas()">Crear</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Función para seleccionar o deseleccionar todos los checkboxes
        function toggleSelectAll(source) {
            const checkboxes = document.querySelectorAll('.employee-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = source.checked;
            });
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
            // Enviar empleados seleccionados al backend

            //console.log(selectedEmployees);
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
                        console.log("Nominas creadas:", data);
                        const modal = bootstrap.Modal.getInstance(document.getElementById('liquidacionModal'));
                        modal.hide();
                        //location.reload();

                        // Aquí puedes agregar código para actualizar la tabla o la vista después de la creación
                    })
                    .catch(error => console.error("Error al crear las nóminas:", error));
            });

        }
    </script>
    @endsection