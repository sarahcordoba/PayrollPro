@extends('layouts.app')

@section('title', 'Nuevo Empleado/a')

@section('content')
    <div class="container-index-empleados">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="lefte-div">
            <h1>Empleados </h1>
            <select id="year-selector" class="form-select d-inline-block w-auto">
                <option value="2024">2024</option>
            </select>
            </div>
            <div>
                <a href="{{ route('empleados.create') }}" class="btn btn-primary">+ Nuevo empleado</a>
            </div>
        </div>
        <div class="mede-div">
            <p>Crea tus empleados uno a uno.</p>
            <p>Total de empleados: {{ count($empleados) }}</p>
        </div>
        <div class="body-empleado">
            <div class="empleado-body">
                <input type="text" id="search-input" class="form-control mb-3"
                    placeholder="Buscar por nombre, cargo, identificación o salario">
                    
                <table class="table table-hover table-bordered table-responsive tabla-empleados" >
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Cargo</th>
                            <th scope="col">Id</th>
                            <th scope="col">Salario</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="empleados-tbody">
                        @foreach ($empleados as $empleado)
                            <tr>
                                <td>{{ $empleado->primer_nombre }} {{ $empleado->segundo_nombre }}
                                    {{ $empleado->primer_apellido }} {{ $empleado->segundo_apellido }}</td>
                                <td>{{ $empleado->cargo }}</td>
                                <td>{{ $empleado->numero_identificacion }}</td>
                                <td>{{ number_format($empleado->salario, 2) }}</td>
                                <td>
                                    <a href="{{ route('empleados.show', $empleado->id) }}" class="btn btn-secondary btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>

    <script>
        document.getElementById('search-input').addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#empleados-tbody tr');

            rows.forEach(row => {
                let nombre = row.cells[0].innerText.toLowerCase();
                let cargo = row.cells[1].innerText.toLowerCase();
                let id = row.cells[2].innerText.toLowerCase();
                let salario = row.cells[3].innerText.toLowerCase();

                if (nombre.includes(filter) || cargo.includes(filter) || id.includes(filter) || salario
                    .includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

@endsection
