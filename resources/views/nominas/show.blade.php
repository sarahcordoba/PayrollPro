@extends('layouts.app')

@section('title', 'Colilla de Pago')

@section('content')
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
                    <li class="list-group-item"><strong>Empleado:</strong> {{ $nomina->empleado->primer_nombre}} {{ $nomina->empleado->segundo_nombre}} {{ $nomina->empleado->primer_apellido}} {{ $nomina->empleado->segundo_apellido}}</li>
                    <li class="list-group-item"><strong>Identificacion:</strong> {{ $nomina->empleado->id}}</li>
                    <li class="list-group-item"><strong>Periodo de liquidacion:</strong> {{ $nomina->liquidacion->fecha_inicio }} - {{ $nomina->liquidacion->fecha_fin }}</li>
                    <li class="list-group-item"><strong>Estado:</strong> {{ $nomina->estado }}</li>
                </ul>
            </div>
            <div class="card">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Concepto</th>
                            <th scope="col">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Salario</strong></td>
                            <td>${{ number_format($nomina->salario_base, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total deducciones</strong></td>
                            <td>${{ number_format($nomina->total_deducciones, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total comisiones</strong></td>
                            <td>${{ number_format($nomina->total_comisiones, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td>${{ number_format($nomina->total, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <p style="font-size:x-large"><strong>Comisiones</strong></p>

            <div class="card">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Tipo</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Porcentaje</th>
                            <th scope="col">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comisionesAplicadas as $comisiona)
                        <tr>
                            <td>{{ $comisiona->comision->tipo }}</td>
                            <td>{{ $comisiona->comision->descripcion }}</td>
                            <td>
                                @if($comisiona->esporcentaje)
                                {{ $comisiona->monto }}%
                                @else
                                N/A
                                @endif
                            </td>
                            <td>
                                @if($comisiona->comision->esporcentaje)
                                {{-- Calcula el monto como el porcentaje del salario --}}
                                ${{ number_format($nomina->empleado->salario * ($comisiona->monto), 2) }}
                                @else
                                {{-- Muestra el monto directamente si no es un porcentaje --}}
                                ${{ number_format($comisiona->monto, 2) }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <p style="font-size:x-large"><strong>Deducciones</strong></p>

            <div class="card">
                <ul class="list-group">
                    @foreach($deduccionesAplicadas as $deducciona)
                    <ul class="list-group list-group-horizontal list-group-flush">
                        <li class="list-group-item d-flex flex-column">
                            <strong>Tipo</strong> {{ $deducciona->deduccion->tipo }}
                        </li>
                        <li class="list-group-item d-flex flex-column">
                            <strong>Descripción</strong> {{ $deducciona->deduccion->descripcion }}
                        </li>
                        <li class="list-group-item d-flex flex-column">
                            <strong>Porcentaje</strong>
                            @if($deducciona->esporcentaje)
                            {{ $deducciona->monto }}%
                            @else
                            N/A
                            @endif
                        </li>
                        <li class="list-group-item d-flex flex-column">
                            <strong>Monto</strong>
                            @if($deducciona->esporcentaje)
                            {{-- Calcula el monto como el porcentaje del salario --}}
                            ${{ number_format($nomina->empleado->salario * ($deducciona->monto), 2) }}
                            @else
                            {{-- Muestra el monto directamente si no es un porcentaje --}}
                            ${{ number_format($deducciona->monto, 2) }}
                            @endif
                        </li>
                    </ul>
                    @endforeach

                </ul>
            </div>
        </div>
    </div>
    <div style="display:flex; justify-content: space-between;">

        <a href="{{ route('nominas.show', $nomina->id) }}" class="btn btn-secondary btn-style">Cancelar</a>
        <div style="display:flex;  gap: .5rem;">
            <a href="{{ route('nominas.edit', $nomina->id) }}" class="btn btn-primary btn-style">Editar</a>

            @if ($nomina->estado != 'Liquidado')
            <!-- Trigger Button -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalLiquidar">
                Liquidar
            </button>
            @endif
        </div>
    </div>
</div>

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
                        <option value="transferencia_bancaria" {{ $nomina->empleado->metodo_pago == 'transferencia_bancaria' ? 'selected' : '' }}>Transferencia bancaria {{ $nomina->empleado->metodo_pago == 'transferencia_bancaria' ? '(Seleccion del cliente)' : '' }}</option>
                        <option value="cheque_bancario" {{ $nomina->empleado->metodo_pago == 'cheque_bancario' ? 'selected' : '' }}>Cheque bancario {{ $nomina->empleado->metodo_pago == 'cheque_bancario' ? '(Seleccion del cliente)' : '' }}</option>
                        <option value="pago_especie" {{ $nomina->empleado->metodo_pago == 'pago_especie' ? 'selected' : '' }}>Pago en especie (bonos o vales) {{ $nomina->empleado->metodo_pago == 'pago_especie' ? '(Seleccion del cliente)' : '' }}</option>
                    </select>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Confirmar Liquidación</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection