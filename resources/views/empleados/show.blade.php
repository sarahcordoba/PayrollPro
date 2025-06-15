@php
    $tiposIdentificacion = [
        'cedula_ciudadania' => 'Cédula de ciudadanía',
        'cedula_extranjeria' => 'Cédula de extranjería',
        'pasaporte' => 'Pasaporte',
        'documento_extranjero' => 'Documento de identificación extranjero',
        'nit' => 'NIT',
    ];

    $tiposContrato = [
        'termino_fijo' => 'Término Fijo',
        'termino_indefinido' => 'Término Indefinido',
        'labor_obra' => 'Labor u obra',
        'aprendizaje' => 'Aprendizaje',
        // 'practica'        => 'Práctica',
        // 'pasantia'        => 'Pasantía',
    ];

    $nivelesRiesgo = [
        'I' => 'Riesgo I - 0.522%',
        'II' => 'Riesgo II - 1.044%',
        'III' => 'Riesgo III - 2.436%',
        'IV' => 'Riesgo IV - 4.350%',
        'V' => 'Riesgo V - 6.960%',
    ];

    $areas = [
        'administrativa' => 'Administrativa',
        'operativa' => 'Operativa',
        'ventas' => 'Ventas',
    ];

    $metodosPago = [
        'pago_efectivo' => 'Pago en efectivo',
        'transferencia_bancaria' => 'Transferencia bancaria',
        'cheque_bancario' => 'Cheque bancario',
        'pago_especie' => 'Pago en especie (bonos o vales)',
    ];

    $tiposCuenta = [
        'corriente' => 'Corriente',
        'ahorro' => 'Ahorro',
        'billetera_digital' => 'Billetera digital',
    ];

    $frecuenciasPago = [
        'mensual' => 'Mensual',
        'quincenal' => 'Quincenal',
    ];

    $bancos = [
        'bancamia' => 'Bancamía',
        'bancolombia' => 'Bancolombia',
        'bancoomeva' => 'Bancoomeva',
        'banco_agrario' => 'Banco Agrario',
        'banco_av_villas' => 'Banco AV Villas',
        'banco_caja_social' => 'Banco Caja Social',
        'banco_credifinanciera' => 'Banco Credifinanciera',
        'banco_bogota' => 'Banco de Bogotá',
        'banco_occidente' => 'Banco de Occidente',
        'banco_falabella' => 'Banco Falabella',
        'banco_finandina' => 'Banco Finandina',
        'banco_gnb_sudameris' => 'Banco GNB Sudameris',
        'banco_jp_morgan' => 'Banco J.P. MORGAN',
        'banco_mundo_mujer' => 'Banco Mundo Mujer',
        'banco_nu' => 'Banco NU',
        'banco_pichincha' => 'Banco Pichincha',
        'banco_popular' => 'Banco Popular',
        'banco_santander' => 'Banco Santander',
        'banco_serfinanza' => 'Banco Serfinanza',
        'banco_w' => 'Banco W',
        'bbva' => 'BBVA',
        'citibank' => 'Citibank',
        'coopcentral' => 'Coopcentral',
        'cooperativa_confiar' => 'Cooperativa Confiar',
        'cooperativa_cootramed' => 'Cooperativa Cootramed',
        'cooperativa_cotrafa' => 'Cooperativa Cotrafa',
        'cooperativa_acn' => 'Cooperativa de Ahorro y Crédito Nacional',
        'cooperativa_fa' => 'Cooperativa Financiera de Antioquia',
        'cooperativa_uh' => 'Cooperativa Utrahuilca',
        'cooprofesores' => 'Cooprofesores',
        'davivienda' => 'Davivienda',
        'daviplata' => 'Daviplata',
        'mibanco' => 'Mibanco',
        'nequi' => 'Nequi',
        'itau' => 'Itaú',
        'scotibank_colpatria' => 'Scotibank Colpatria',
        'juriscoop' => 'Juriscoop',
        'dale' => 'DALE',
        'crediflores' => 'Crediflores',
        'lulo_bank' => 'Lulo Bank',
        'global66' => 'Global66',
        'rappipay' => 'RappiPay',
    ];

    $subtiposTrabajador = [
        'no_aplica' => 'No Aplica',
        'dependiente_pensionado_vejez' => 'Dependiente vejez activa',
    ];

    $tiposTrabajador = [
        1 => 'Dependiente',
        2 => 'Servicio doméstico',
        3 => 'Independiente',
        4 => 'Madre comunitaria',
        12 => 'Aprendices del SENA en etapa lectiva',
        15 => 'Desempleado con subsidio de Caja de Compensación Familiar',
        16 => 'Independiente agremiado o asociado',
        18 => 'Funcionarios públicos sin tope máximo en el IBC',
        19 => 'Aprendices del SENA en etapa productiva',
        20 => 'Estudiantes (Régimen Especial – Ley 789/2002)',
        21 => 'Estudiantes de postgrado en salud (Decreto 190 de 1996)',
        22 => 'Profesor de establecimiento particular',
        30 => 'Dependiente, entidades o universidades públicas con régimen especial en salud',
        31 => 'Cooperados o PreCooperativas de trabajo asociado',
        32 => 'Miembro carrera diplomática/consular extranjera o funcionario multilateral',
        33 => 'Beneficiario del Fondo de Solidaridad Pensional',
        34 => 'Concejal amparado por una póliza de salud',
        40 => 'Beneficiario UPC adicional',
        41 => 'Independiente sin ingresos con pago por terceros',
        42 => 'Cotizante solo salud (Art. 2, Ley 1250/2008)',
        43 => 'Independiente no obligado a pensión con pago por terceros',
        44 => 'Dependiente en Empleo de Emergencia (≥ 1 mes)',
        45 => 'Dependiente en Empleo de Emergencia (< 1 mes)',
        47 => 'Trabajador dependiente de entidad beneficiaria del SGP',
    ];

@endphp
@extends('layouts.app')

@section('title', 'Detalles del Empleado')

@section('content')
    <div class="container-show-empleados">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="lefte-div">
                <h1>Detalles del Empleado</h1>
            </div>
            <div>
                <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-primary btn-style"><i class="bi bi-pencil"> Editar</i></a>
            </div>
        </div>
        <div class="body-empleado">
            <div class="empleado-body">
                <div class="header">
                    <div class="details">
                        <div class="name">{{ $empleado->primer_nombre }} {{ $empleado->segundo_nombre }}
                            {{ $empleado->primer_apellido }} {{ $empleado->segundo_apellido }}</div>
                        <div class="salary">Activo</div>
                    </div>
                </div>

                <div class="content-card">
                    <div class="card sb-light shadow r w-100" style="height: 6rem">
                        <ul class="list-group list-group-flush list-group-horizontal sb-light">

                            <li class="list-group-item flex-fill">
                                <strong>Inicio de labores</strong><br>
                                {{ $empleado->fecha_contratacion }}
                            </li>

                            <li class="list-group-item flex-fill">
                                <strong>Tiempo laborado</strong><br>
                                {{ $empleado->dias_trabajados }} días
                            </li>

                            <li class="list-group-item flex-fill">
                                <strong>Cargo</strong><br>
                                {{ $empleado->cargo }}
                            </li>

                            <li class="list-group-item flex-fill">
                                <strong>Salario</strong><br>
                                {{ $empleado->salario }}
                            </li>

                        </ul>
                    </div>
                </div>

                {{-- <div class="tabs">
                    <div class="tab active">Información general</div>
                    <div class="tab">Laboral</div>
                </div> --}}

                <div class="tabs">
                    <div class="tab active" data-target="#tab-general">Información general</div>
                    <div class="tab" data-target="#tab-laboral">Laboral</div>
                </div>


                <div id="tab-general" class="tab-content">
                    <div class="empleado-info-grid">
                        <div class="card sb-light shadow div1">
                            <h5><strong>Datos Personales</strong></h5>
                            <p><strong>Tipo de identificación</strong><br>
                                {{ $tiposIdentificacion[$empleado->tipo_identificacion] ?? $empleado->tipo_identificacion }}
                            </p>
                            <p><strong>Número de identificación</strong><br>{{ $empleado->numero_identificacion }}</p>
                            <p><strong>Municipio</strong><br>{{ $empleado->municipio }}</p>
                            <p><strong>Dirección</strong><br>{{ $empleado->direccion }}</p>
                            <p><strong>Celular</strong><br>{{ $empleado->celular }}</p>
                            <p><strong>Correo</strong><br>{{ $empleado->correo }}</p>
                        </div>

                        <div class="card sb-light shadow">
                            <h5><strong>Afiliaciones</strong></h5>

                            <div class="grid-doble">
                                <p><strong>EPS</strong><br>{{ $empleado->eps }}</p>
                                <p><strong>Caja de Compensación</strong><br>{{ $empleado->caja_compensacion }}</p>
                                <p><strong>Fondo de Pensiones</strong><br>{{ $empleado->fondo_pensiones }}</p>
                                <p><strong>Fondo de Cesantías</strong><br>{{ $empleado->fondo_cesantias }}</p>
                            </div>
                        </div>

                        <div class="card sb-light shadow">
                            <h5><strong>Datos de Pago</strong></h5>

                            <div class="grid-doble">
                                <p><strong>Método de
                                        Pago</strong><br>{{ $empleado->metodo_pago ? ($metodosPago[$empleado->metodo_pago] ?? $empleado->metodo_pago) : 'No aplica'}}
                                </p>
                                <p><strong>Banco</strong><br>{{ $empleado->banco ? ($bancos[$empleado->banco] ?? $empleado->banco) : 'No aplica' }}</p>
                                <p><strong>Número de Cuenta</strong><br>{{ $empleado->numero_cuenta ?? 'No aplica' }}</p>
                                <p><strong>Tipo de
                                        Cuenta</strong><br>{{ $empleado->tipo_cuenta ? ($tiposCuenta[$empleado->tipo_cuenta] ?? $empleado->tipo_cuenta) : 'No aplica' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="tab-laboral" class="tab-content d-none">

                    <div class="empleado-info-grid">
                        <div class="card sb-light shadow div1">
                            <h5><strong>Datos del Contrato</strong></h5>
                            <p><strong>Tipo de Contrato</strong><br>
                                {{ $tiposContrato[$empleado->tipo_contrato] ?? $empleado->tipo_contrato }}
                            </p>
                            <p><strong>Fecha de Contratación</strong><br>{{ $empleado->fecha_contratacion }}</p>
                            <p><strong>Fecha Finalización Contrato</strong><br>{{ $empleado->fecha_fin_contrato }}</p>
                            <p><strong>Salario</strong><br>{{ $empleado->salario }}</p>
                            <p><strong>Salario
                                    Integral</strong><br>{{ $empleado->salario_integral ? 'Sí aplica' : 'No aplica' }}</p>
                            <p><strong>Auxilio de
                                    Transporte</strong><br>{{ $empleado->auxilio_transporte ? 'Sí aplica' : 'No aplica' }}
                            </p>
                        </div>

                        <div class="card sb-light shadow">
                            <h5><strong>Clasificación del Trabajador</strong></h5>

                            <div class="grid-doble">
                                <p><strong>Tipo
                                        Trabajador</strong><br>{{ $tiposTrabajador[$empleado->tipo_trabajador] ?? $empleado->tipo_trabajador }}
                                </p>
                                <p><strong>Subtipo
                                        Trabajdor</strong><br>{{ $subtiposTrabajador[$empleado->subtipo_trabajador] ?? $empleado->subtipo_trabajador }}
                                </p>
                                <p><strong>Alto Riesgo</strong><br>{{ $empleado->alto_riesgo ? 'Sí aplica' : 'No aplica' }}
                                </p>
                                <p><strong>Nivel de Riesgo</strong><br>
                                    {{ $nivelesRiesgo[$empleado->nivel_riesgo] ?? $empleado->nivel_riesgo }}</p>
                            </div>
                        </div>

                        <div class="card sb-light shadow">
                            <h5><strong>Asignación Interna</strong></h5>

                            <div class="grid-doble">
                                <p><strong>Cargo</strong><br>{{ $empleado->cargo }}</p>
                                <p><strong>Área</strong><br>
                                    {{ $areas[$empleado->area] ?? $empleado->area }}</p>
                                <p><strong>Días Vacaciones</strong><br>{{ $empleado->dias_vacaciones }}</p>
                                <p><strong>Sábado
                                        Laboral</strong><br>{{ $empleado->sabado_laboral ? 'Sí aplica' : 'No aplica' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="btn-final-show-e">
            <a href="{{ route('empleados.index') }}" class="btn btn-secondary btn-style">Volver a la lista</a>
        </div>

    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.tabs .tab').forEach(tab => {
                tab.addEventListener('click', () => {
                    document.querySelectorAll('.tabs .tab').forEach(t => t.classList.remove(
                        'active'));
                    tab.classList.add('active');

                    document.querySelectorAll('.tab-content').forEach(c => c.classList.add(
                        'd-none'));
                    const target = tab.getAttribute('data-target');
                    document.querySelector(target).classList.remove('d-none');
                });
            });
        });
    </script>
@endsection
