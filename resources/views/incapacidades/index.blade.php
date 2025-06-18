@extends('layouts.app')

@section('title', 'Empleados')

@section('content')
<div class="container-index-empleados">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="lefte-div">
            <h1>Incapacidades</h1>
        </div>
    </div>
    <div class="mede-div">
        <p>Revisa las incapacidades de tus empleados.</p>
    </div>
    <div class="body-empleado">
        <div class="empleado-body">
            <input type="text" id="search-input" class="form-control mb-3"
                placeholder="Buscar por nombre, cargo, identificación o salario">

            <table class="table table-hover table-bordered table-responsive tabla-empleados">
                <thead>
                    <tr>
                        <th scope="col">Fechas</th>
                        <th scope="col">Empleado</th>
                        <th scope="col">Dias</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="empleados-tbody">
                    @foreach ($incapacidades as $incapacidad)
                    <tr>
                        <td>{{ $incapacidad->fecha_inicio }} - {{ $incapacidad->fecha_fin }}
                        </td>
                        <td> {{ $incapacidad->empleado->primer_nombre }}
                            {{ $incapacidad->empleado->segundo_nombre }}
                            {{ $incapacidad->empleado->primer_apellido }}
                            {{ $incapacidad->empleado->segundo_apellido }}
                        </td>
                        <td>{{ $incapacidad->dias_incapacidad }}</td>
                        <td>{{ $incapacidad->tipo_incapacidad }}</td>
                        <td>{{ $incapacidad->estado }}</td>

                        <td>
                            <a href="{{ route('incapacidades.show', $incapacidad->id) }}" class="btn btn-sm btn-secondary">
                                <i class="bi bi-eye"></i>
                            </a>

                            @if ($incapacidad->soporte)
                            <a href="{{ asset('storage/' . $incapacidad->soporte) }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="bi bi-download"></i>
                            </a>
                            @endif

                            <form action="{{ route('incapacidades.destroy', $incapacidad->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
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