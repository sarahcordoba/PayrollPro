@extends('layouts.app')

@section('title', 'Lq')

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

        <a href="{{ route('nominas.show', $nomina->id) }}" class="btn btn-secondary">Cancelar</a>
        <div style="display:flex;  gap: .5rem;">
            <a href="{{ route('nominas.edit', $nomina->id) }}" class="btn btn-primary">Editar</a>

            <a href="{{ route('nominas.liquidar', $nomina->id) }}" class="btn btn-primary">Liquidar</a>
        </div>
    </div>

</div>
@endsection