@extends('layouts.app')

@section('title', 'Liquidaciones')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container-index-liquidaciones">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <div class="lefte-div">
      <h1>Pagos </h1>
    </div>
  </div>
  <div class="mede-div">
    <p>Revisa los pagos realizados a tus empleados.</p>
  </div>
  <div class="body-liquidaciones">
    <div class="liquidacion-body">
      <input type="text" id="search-input" class="form-control mb-3"
        placeholder="Buscar por nombre, cargo, identificación o salario.">

      <table class="table table-hover table-bordered table-responsive tabla-empleados">
        <thead>
          <tr>
            <th scope="col">Nombre</th>
            <th scope="col">ID</th>
            <th scope="col">Fecha de Pago</th>
            <th scope="col">Monto</th>
            <th scope="col">Acción</th>
          </tr>
        </thead>
        <tbody class="deduccion-tbody">
          @foreach($pagos as $pago)
          <tr>
            <td>{{ $pago->empleado->primer_nombre }} {{ $pago->empleado->segundo_nombre }}
              {{ $pago->empleado->primer_apellido }} {{ $pago->empleado->segundo_apellido }}
            </td>
            <td>{{ $pago->empleado->id }}</td>
            <td>{{ $pago->fecha_pago}}</td>
            <td>$ {{ number_format($pago->total_pagado,2)}}</td>
            <td>
              <button type="button" class="btn btn-secondary"
                data-bs-toggle="modal"
                data-bs-target="#modalDetallePago"
                data-pago='@json($pago)'>
                Detalles
              </button>
              <form action="{{ route('pagos.destroy', $pago->id) }}" method="POST">
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
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalDetallePago" tabindex="-1" aria-labelledby="modalDetallePagoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetallePagoLabel">Detalle del Pago</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <p><strong>ID Empleado:</strong> <span id="modal-id-empleado"></span></p>
        <p><strong>Nombre:</strong> <span id="modal-nombre"></span></p>
        <p><strong>Fecha de Pago:</strong> <span id="modal-fecha-pago"></span></p>
        <p><strong>Total Devengado:</strong> $<span id="modal-total-devengado"></span></p>
        <p><strong>Total Deducciones:</strong> $<span id="modal-total-deducciones"></span></p>
        <p><strong>Total Pagado:</strong> $<span id="modal-total-pagado"></span></p>
        <p><strong>Estado del Pago:</strong> <span id="modal-estado-pago"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modalDetallePago');

    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const pago = button.getAttribute('data-pago');
        const data = JSON.parse(pago);

        document.getElementById('modal-id-empleado').textContent = data.empleado_id;
        document.getElementById('modal-nombre').textContent = button.closest('tr').children[0].textContent.trim();
        document.getElementById('modal-fecha-pago').textContent = data.fecha_pago;
        document.getElementById('modal-total-devengado').textContent = parseFloat(data.total_devengado).toFixed(2);
        document.getElementById('modal-total-deducciones').textContent = parseFloat(data.total_deducciones).toFixed(2);
        document.getElementById('modal-total-pagado').textContent = parseFloat(data.total_pagado).toFixed(2);
        document.getElementById('modal-estado-pago').textContent = data.estado_pago;
    });
});
</script>


@endsection