@extends('layouts.app')

@section('title', 'Detalles del Empleado')

@section('content')
<script>
    function printIncapacidad() {
        const contenido = document.getElementById("incapacidadResumen").innerHTML;
        const ventana = window.open('', '', 'height=800,width=600');

        ventana.document.write('<html><head><title>Resumen de Incapacidad</title>');
        ventana.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">');
        ventana.document.write('</head><body>');
        ventana.document.write(contenido);
        ventana.document.write('</body></html>');

        ventana.document.close();
        ventana.focus();

        // Wait for styles to load before printing
        setTimeout(() => {
            ventana.print();
            ventana.close();
        }, 500);
    }
</script>

<div class="container">
    <h1>Detalles de la Incapacidad</h1>

    <div class="card" style="width: 100%; height: fit-content" id="incapacidadResumen">
        <div class="card-body text-center">
            <p style="font-size:xx-large"><strong>Resumen de la Incapacidad</strong></p>

            <div class="card mb-3">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>ID:</strong> {{ $incapacidad->id }}</li>
                    <li class="list-group-item"><strong>ID Empleado:</strong> {{ $incapacidad->empleado->id }}</li>
                    <li class="list-group-item"><strong>Empleado:</strong> {{ $incapacidad->empleado->primer_nombre }} {{ $incapacidad->empleado->segundo_nombre }} {{ $incapacidad->empleado->primer_apellido }} {{ $incapacidad->empleado->segundo_apellido }}</li>
                    <li class="list-group-item"><strong>Periodo de incapacidad:</strong> {{ $incapacidad->fecha_inicio }} - {{ $incapacidad->fecha_fin }}</li>
                    <li class="list-group-item"><strong>Tipo de Incapacidad:</strong> {{ $incapacidad->tipo_incapacidad }}</li>
                </ul>
            </div>

            <div class="card mb-3">
                <table class="table">
                    <tbody>
                        <tr>
                            <td><strong>Días de Incapacidad</strong></td>
                            <td>{{ $incapacidad->dias_incapacidad ?? 'No especificado' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha de Registro</strong></td>
                            <td>{{ $incapacidad->fecha_registro }}</td>
                        </tr>
                        <tr>
                            <td><strong>Estado</strong></td>
                            <td>{{$incapacidad->estado}}</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha de Revisión</strong></td>
                            <td>{{ $incapacidad->fecha_revision ?? 'No revisado' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p style="font-size:x-large"><strong>Descripción</strong></p>
            <div class="card p-3 mb-3">
                <p>{{ $incapacidad->descripcion ?? 'No se registró descripción' }}</p>
            </div>

            <p style="font-size:x-large"><strong>Soporte</strong></p>
            <div class="card p-3 mb-3">
                @if ($incapacidad->soporte)
                <a href="{{ asset('storage/' . $incapacidad->soporte) }}" target="_blank">Ver soporte adjunto</a>
                @else
                <p>No se adjuntó soporte</p>
                @endif
            </div>

            <p style="font-size:x-large"><strong>Observaciones de RRHH</strong></p>
            <div class="card p-3 mb-3">
                <p>{{ $incapacidad->observaciones_rrhh ?? 'Sin observaciones registradas' }}</p>
            </div>

        </div>
    </div>

    <div style="display:flex; justify-content: space-between;">
        <div style="display:flex; gap: 0.5rem;">
            <a href="{{ route('incapacidades.index') }}" class="btn btn-secondary btn-style">Volver</a>
            <a class="btn btn-primary btn-style" onclick="printIncapacidad()">Imprimir</a>
        </div>

        @if ($incapacidad->estado != 'Revisado')
        <div style="display:flex; gap: 0.5rem;">
            <button class="btn btn-danger btn-style" data-bs-toggle="modal" data-bs-target="#modalRechazo">Rechazar</button>
            <button class="btn btn-primary btn-style" data-bs-toggle="modal" data-bs-target="#modalAprobacion">Aceptar</button>
        </div>
        @endif

    </div>
</div>

<!-- Modal Aceptar -->
<div class="modal fade" id="modalAprobacion" tabindex="-1" aria-labelledby="modalAprobacionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('incapacidades.review', $incapacidad->id) }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAprobacionLabel">Aceptar Incapacidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <label for="observaciones_aprobacion" class="form-label">Observaciones de RRHH</label>
                    <textarea name="observaciones_rrhh" class="form-control" id="observaciones_aprobacion" rows="4" required></textarea>

                    <input type="hidden" name="estado" value="Revisado">
                    <input type="hidden" name="accion" value="aceptar">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-style" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-style">Enviar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Rechazar -->
<div class="modal fade" id="modalRechazo" tabindex="-1" aria-labelledby="modalRechazoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('incapacidades.review', $incapacidad->id) }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRechazoLabel">Rechazar Incapacidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <label for="observaciones_rechazo" class="form-label">Motivo del Rechazo</label>
                    <textarea name="observaciones_rrhh" class="form-control" id="observaciones_rechazo" rows="4" required></textarea>

                    <input type="hidden" name="estado" value="Revisado">
                    <input type="hidden" name="accion" value="rechazar">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-style" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger btn-style">Enviar</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection