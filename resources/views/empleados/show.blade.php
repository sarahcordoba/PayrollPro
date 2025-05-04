@extends('layouts.app')

@section('title', 'Detalles del Empleado')

@section('content')
    <div class="container-show-empleados">
        <div class="header">
            <div class="details">
                <div class="name">{{ $empleado->primer_nombre }} {{ $empleado->segundo_nombre }}
                    {{ $empleado->primer_apellido }} {{ $empleado->segundo_apellido }}</div>
                <div class="salary">Salario: $ {{ number_format($empleado->salario_neto, 2) }}</div>
            </div>
            <div class="actions">
                <button class="dots">⋮</button>
                <button class="edit-button">✏️ Editar</button>
                <button class="new-button">+ Nueva novedad</button>
            </div>
        </div>

        <div class="tabs">
            <div class="tab active">Información general</div>
            <div class="tab">Conceptos recurrentes</div>
        </div>

        <div class="content-card">
            <div class="info-card">
                <div class="title">Inicio de labores</div>
                <div class="value">{{ $empleado->fecha_contratacion }}</div>
            </div>
            <div class="info-card">
                <div class="title">Tiempo laborado</div>
                <div class="value">{{ $empleado->dias_trabajados }} días</div>
            </div>
            <div class="info-card">
                <div class="title">Cargo</div>
                <div class="value">{{ $empleado->cargo }}</div>
            </div>
            <div class="info-card">
                <div class="title">Salario neto</div>
                <div class="value">$ {{ number_format($empleado->salario_neto, 2) }}</div>
            </div>
            <div class="info-card">
                <div class="title">Días de vacaciones</div>
                <div class="value">{{ $empleado->dias_vacaciones }}</div>
            </div>
        </div>

        <!-- Sección de Tarjetas -->
        <div class="row mt-4">
            <div class="col">
                <div class="information-card">
                    <h5>Información General</h5>

                    <div class="col-md-6 mb-3">
                        <div>
                            <strong class="papa">Tipo de Identificación</strong class="papa">
                        </div>
                        <div class="value">
                            {{ $empleado->tipo_identificacion }}
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div>
                            <strong class="papa">Número de Identificación</strong class="papa">
                        </div>
                        <div class="value">
                            {{ $empleado->numero_identificacion }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div>
                            <strong class="papa">Municipio</strong class="papa">
                        </div>
                        <div class="value">
                            {{ $empleado->municipio }}
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div>
                            <strong class="papa">Dirección</strong class="papa">
                        </div>
                        <div class="value">
                            {{ $empleado->direccion }}
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div>
                            <strong class="papa">Celular</strong class="papa">
                        </div>
                        <div class="value">
                            {{ $empleado->celular }}
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div>
                            <strong class="papa">Correo Electrónico</strong class="papa">
                        </div>
                        <div class="value">
                            {{ $empleado->correo }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="information-card ">
                    <h5>Información Laboral</h5>
                    <div class="card-body">
                        <div class="mb-3">
                            <div>
                                <strong class="papa">Tipo de Contrato</strong class="papa">
                            </div>
                            <div class="value">
                                {{ $empleado->tipo_contrato }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <div>
                                <strong class="papa">Salario</strong class="papa">
                            </div>
                            <div class="value">
                                ${{ number_format($empleado->salario, 2) }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <div>
                                <strong class="papa">Tipo de Trabajador</strong class="papa">
                            </div>
                            <div class="value">
                                {{ $empleado->tipo_trabajador }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <div>
                                <strong class="papa">Subtipo de Trabajador</strong class="papa">
                            </div>
                            <div class="value">
                                {{ $empleado->subtipo_trabajador }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <div>
                                <strong class="papa">Área</strong class="papa">
                            </div>
                            <div class="value">
                                {{ $empleado->area }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <div>
                                <strong class="papa">Puesto de Trabajo</strong class="papa">
                            </div>
                            <div class="value">
                                {{ $empleado->puesto_trabajo }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <div>
                                <strong class="papa">Frecuencia de Pago</strong class="papa">
                            </div>
                            <div class="value">
                                {{ $empleado->frecuencia_pago }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <div class="information-card">
                    <h5>Datos de Pago</h5>

                    <div class="col-md-6 mb-3">
                        <div>
                            <strong class="papa">Método de Pago</strong class="papa">
                        </div>
                        <div class="value"> 
                            {{ $empleado->metodo_pago }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div>
                            <strong class="papa">Banco</strong class="papa">
                        </div>
                        <div class="value">
                            {{ $empleado->banco ?? 'no aplica' }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div>
                            <strong class="papa">Número de Cuenta</strong class="papa">
                        </div>
                        <div class="value">
                            {{ $empleado->numero_cuenta ?? 'no aplica' }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div>
                            <strong class="papa">Tipo de Cuenta</strong class="papa">
                        </div>
                        <div class="value">
                            {{ $empleado->tipo_cuenta ?? 'no aplica' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="information-card">
                    <h5>Entidades</h5>

                    <div class="col-md-6 mb-3">
                        <div>
                            <strong class="papa">EPS</strong class="papa">
                        </div>
                        <div class="value">
                            {{ $empleado->eps }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div>
                            <strong class="papa">Fondo de Pensión</strong class="papa">
                        </div>
                        <div class="value">
                            {{ $empleado->fondo_pensiones }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div>
                            <strong class="papa">Fondo de Cesantías</strong class="papa">
                        </div>
                        <div class="value">
                            {{ $empleado->fondo_cesantias }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div>
                            <strong class="papa">Caja de Compensación</strong class="papa">
                        </div>
                        <div class="value">
                            {{ $empleado->caja_compensacion }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('empleados.index') }}" class="btn btn-secondary mt-3">Volver a la lista</a>
    </div>
@endsection
