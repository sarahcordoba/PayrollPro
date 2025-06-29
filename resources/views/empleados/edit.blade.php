@extends('layouts.app')

@section('title', 'Editar Empleado/a')

@section('content')
    <div class="container">
        <h1 class="titulito">Editar empleado/a</h1>
        <p>Edita la información de nómina de las personas que integran tu equipo de trabajo.</p>
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

        <form action="{{ route('empleados.update', $empleado->id) }}" method="POST" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="progres">
                <div class="progress-bar">
                    <div class="progress-bar-fill"></div>
                </div>
                <div class="step-container">
                    <div class="step" id="step1">
                        <div class="step-indicator">1</div>
                        <div class="step-label">Datos principales</div>
                    </div>
                    <div class="step" id="step2">
                        <div class="step-indicator">2</div>
                        <div class="step-label">Contrato</div>
                    </div>
                    <div class="step" id="step3">
                        <div class="step-indicator">3</div>
                        <div class="step-label">Datos de pago</div>
                    </div>
                </div>
            </div>

            <!-- Datos principales -->
            <div class="form-section active" id="form1">
                <div class="card mb-3">
                    <div class="card-header">Datos principales</div>
                    <div class="card-body">
                        {{-- <div class="row"> --}}
                        <div class="form-group">
                            <label class="requir" for="primer_nombre">Primer nombre</label>
                            <input type="text" id="primer_nombre" name="primer_nombre" class="form-control" required
                                autocomplete="off" value="{{ old('primer_nombre', $empleado->primer_nombre) }}">
                        </div>
                        <div class="form-group">
                            <label for="segundo_nombre">Segundo nombre</label>
                            <input type="text" id="segundo_nombre" name="segundo_nombre" class="form-control"
                                autocomplete="off" value="{{ old('segundo_nombre', $empleado->segundo_nombre) }}">
                        </div>
                        <div class="form-group">
                            <label class="requir" for="primer_apellido">Primer apellido</label>
                            <input type="text" id="primer_apellido" name="primer_apellido" class="form-control"
                                autocomplete="off" value="{{ old('primer_apellido', $empleado->primer_apellido) }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="segundo_apellido">Segundo apellido</label>
                            <input type="text" id="segundo_apellido" name="segundo_apellido" class="form-control"
                                autocomplete="off" value="{{ old('segundo_apellido', $empleado->segundo_apellido) }}">
                        </div>
                        <div class="form-group"> <label class="requir" for="tipo_identificacion">Tipo de identificación
                            </label> <select id="tipo_identificacion" name="tipo_identificacion" class="form-control"
                                required>
                                <option value="cedula_ciudadania"
                                    {{ old('tipo_identificacion', $empleado->tipo_identificacion) == 'cedula_ciudadania' ? 'selected' : '' }}>
                                    Cédula de ciudadanía</option>
                                <option value="cedula_extranjeria"
                                    {{ old('tipo_identificacion', $empleado->tipo_identificacion) == 'cedula_extranjeria' ? 'selected' : '' }}>
                                    Cédula de extranjería</option>
                                <option value="pasaporte"
                                    {{ old('tipo_identificacion', $empleado->tipo_identificacion) == 'pasaporte' ? 'selected' : '' }}>
                                    Pasaporte</option>
                                <option value="documento_extranjero"
                                    {{ old('tipo_identificacion', $empleado->tipo_identificacion) == 'documento_extranjero' ? 'selected' : '' }}>
                                    Documento de identificación extranjero</option>
                                <option value="nit"
                                    {{ old('tipo_identificacion', $empleado->tipo_identificacion) == 'nit' ? 'selected' : '' }}>
                                    NIT</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="requir" for="numero_identificacion">Número de identificación</label>
                            <input type="text" id="numero_identificacion" name="numero_identificacion"
                                class="form-control" required
                                value="{{ old('numero_identificacion', $empleado->numero_identificacion) }}">
                        </div>
                        {{-- </div> --}}
                    </div>
                </div>



                <!-- Dirección y contacto -->
                <div class="form-section">
                    <div class="card mb-3">
                        <div class="card-header">Dirección y contacto</div>
                        <div class="card-body">
                            {{-- <div class="row"> --}}
                            {{-- <div class="form-group">
                                <label for="municipio">Municipio *</label>
                                <input type="text" id="municipio" name="municipio" class="form-control" required>
                            </div> --}}

                            <div class="form-group"> <label class="requir" for="municipio">Municipio
                                </label> <select id="municipio"
                                    data-selected="{{ old('municipio', $empleado->municipio) }}" name="municipio"
                                    class="form-control" required>
                                </select>
                            </div>

                            {{-- <div class="form-group"> <label class="requir" for="municipio">Municipio
                                </label>
                                <div id="municipios" class="dropdown-container"></div>

                            </div> --}}

                            <div class="form-group">
                                <label class="requir" for="direccion">Dirección</label>
                                <input type="text" id="direccion" name="direccion" class="form-control"
                                    value="{{ old('direccion', $empleado->direccion) }}" required>
                            </div>

                            <div class="form-group">
                                <label class="requir" for="celular">Celular</label>
                                <input type="text" id="celular" name="celular" class="form-control"
                                    value="{{ old('celular', $empleado->celular) }}">
                            </div>

                            <div class="form-group">
                                <label class="requir" for="correo">Correo electrónico</label>
                                <input type="email" id="correo" name="correo" class="form-control"
                                    value="{{ old('correo', $empleado->correo) }}" required>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Contrato -->
            <div class="form-section hidden" id="form2">
                <div class="card mb-3">
                    <div class="card-header">Contrato</div>
                    <div class="card-body">
                        {{-- <div class="row"> --}}
                        <div class="form-group">
                            <label class="requir" for="tipo_contrato">Tipo de contrato</label>
                            <select id="tipo_contrato" name="tipo_contrato" class="form-control" required>
                                <option value="termino_fijo"
                                    {{ old('tipo_contrato', $empleado->tipo_contrato) == 'termino_fijo' ? 'selected' : '' }}>
                                    Término Fijo</option>
                                <option value="termino_indefinido"
                                    {{ old('tipo_contrato', $empleado->tipo_contrato) == 'termino_indefinido' ? 'selected' : '' }}>
                                    Término Indefinido</option>
                                <option value="labor_obra"
                                    {{ old('tipo_contrato', $empleado->tipo_contrato) == 'labor_obra' ? 'selected' : '' }}>
                                    Labor u obra</option>
                                <option value="aprendizaje"
                                    {{ old('tipo_contrato', $empleado->tipo_contrato) == 'aprendizaje' ? 'selected' : '' }}>
                                    Aprendizaje</option>
                            </select>
                        </div>

                        <div class="row_d">
                            <div class="form-group">
                                <label class="requir" for="fecha_contratacion">Fecha de contratación</label>
                                <input type="date" id="fecha_contratacion" name="fecha_contratacion"
                                    class="form-control"
                                    value="{{ old('fecha_contratacion', $empleado->fecha_contratacion) }}" required>
                            </div>
                            <div class="form-group">
                                <label class="requir" for="fecha_fin_contrato">Fecha de fin de contrato</label>
                                <input type="date" id="fecha_fin_contrato" name="fecha_fin_contrato"
                                    class="form-control"
                                    value="{{ old('fecha_fin_contrato', $empleado->fecha_fin_contrato) }}" required>
                            </div>
                        </div>

                        <div class="row_d">
                            <div class="form-group">
                                <label class="requir" for="salario">Salario</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" id="salario" name="salario" class="form-control"
                                        value="{{ old('salario', $empleado->salario) }}" required>
                                </div>
                            </div>

                            <div class="form-group form-group-radio">
                                <label class="requir" for="salario_integral">Salario Integral</label>
                                <div>
                                    <div class="form-check form-check-inline radios">
                                        <input class="form-check-input" type="radio" name="salario_integral"
                                            id="salario_integral_si" value="1"
                                            {{ old('salario_integral', $empleado->salario_integral) == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="salario_integral_si">Sí</label>
                                    </div>
                                    <div class="form-check form-check-inline radios">
                                        <input class="form-check-input" type="radio" name="salario_integral"
                                            id="salario_integral_no" value="0"
                                            {{ old('salario_integral', $empleado->salario_integral) == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="salario_integral_no">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="requir" for="frecuencia_pago">Frecuencia de pago</label>
                            <select id="frecuencia_pago" name="frecuencia_pago" class="form-control" required>
                                <option value="mensual"
                                    {{ old('frecuencia_pago', $empleado->frecuencia_pago) == 'mensual' ? 'selected' : '' }}>
                                    Mensual</option>
                                <option value="quincenal"
                                    {{ old('frecuencia_pago', $empleado->frecuencia_pago) == 'quincenal' ? 'selected' : '' }}>
                                    Quincenal</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="requir" for="tipo_trabajador">Tipo de trabajador</label>
                            <select id="tipo_trabajador"
                                data-selected="{{ old('tipo_trabajador', $empleado->tipo_trabajador) }}"
                                name="tipo_trabajador" class="form-control" required>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="requir" for="subtipo_trabajador">Subtipo de trabajador</label>
                            <select id="subtipo_trabajador" name="subtipo_trabajador" class="form-control" required>
                                <option value="no_aplica"
                                    {{ old('subtipo_trabajador', $empleado->subtipo_trabajador) == 'no_aplica' ? 'selected' : '' }}>
                                    No aplica</option>
                                <option value="dependiente_pensionado_vejez"
                                    {{ old('subtipo_trabajador', $empleado->subtipo_trabajador) == 'dependiente_pensionado_vejez' ? 'selected' : '' }}>
                                    Dependiente pensionado por vejez activa
                                </option>
                                <!-- Agregar más opciones si es necesario -->
                            </select>
                        </div>

                        <div class="row_d">
                            <div class="form-group form-group-radio">
                                <label class="requir" for="auxilio_transporte">Auxilio de transporte</label>
                                <div>
                                    <div class="form-check form-check-inline radios">
                                        <input class="form-check-input" type="radio" name="auxilio_transporte"
                                            id="auxilio_transporte_si" value="1"
                                            @if (old('auxilio_transporte', $empleado->auxilio_transporte) == 1) checked @endif>
                                        <label class="form-check-label" for="auxilio_transporte_si">Sí</label>
                                    </div>
                                    <div class="form-check form-check-inline radios">
                                        <input class="form-check-input" type="radio" name="auxilio_transporte"
                                            id="auxilio_transporte_no" value="0"
                                            @if (old('auxilio_transporte', $empleado->auxilio_transporte) == 0) checked @endif>
                                        <label class="form-check-label" for="auxilio_transporte_no">No</label>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group form-group-radio">
                                <label class="requir" for="alto_riesgo">Alto riesgo</label>
                                <div>
                                    <div class="form-check form-check-inline radios">
                                        <input class="form-check-input" type="radio" name="alto_riesgo"
                                            id="alto_riesgo_si" value="1"
                                            @if (old('alto_riesgo', $empleado->alto_riesgo) == 1) checked @endif>
                                        <label class="form-check-label" for="alto_riesgo_si">Sí</label>
                                    </div>
                                    <div class="form-check form-check-inline radios">
                                        <input class="form-check-input" type="radio" name="alto_riesgo"
                                            id="alto_riesgo_no" value="0"
                                            @if (old('alto_riesgo', $empleado->alto_riesgo) == 0) checked @endif>
                                        <label class="form-check-label" for="alto_riesgo_no">No</label>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group form-group-radio">
                                <label class="requir" for="sabado_laboral">¿Sábado laboral?</label>
                                <div>
                                    <div class="form-check form-check-inline radios">
                                        <input class="form-check-input" type="radio" name="sabado_laboral"
                                            id="sabado_laboral_si" value="1"
                                            @if (old('sabado_laboral', $empleado->sabado_laboral) == 1) checked @endif>
                                        <label class="form-check-label" for="sabado_laboral_si">Sí</label>
                                    </div>
                                    <div class="form-check form-check-inline radios">
                                        <input class="form-check-input" type="radio" name="sabado_laboral"
                                            id="sabado_laboral_no" value="0"
                                            @if (old('sabado_laboral', $empleado->sabado_laboral) == 0) checked @endif>
                                        <label class="form-check-label" for="sabado_laboral_no">No</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="requir" for="nivel_riesgo" class="R">Nivel de riesgo</label>
                            <select id="nivel_riesgo" name="nivel_riesgo" class="form-control" required>
                                <option value="I" @if (old('nivel_riesgo', $empleado->nivel_riesgo) == 'I') selected @endif>Riesgo I - 0.522%
                                </option>
                                <option value="II" @if (old('nivel_riesgo', $empleado->nivel_riesgo) == 'II') selected @endif>Riesgo II - 1.044%
                                </option>
                                <option value="III" @if (old('nivel_riesgo', $empleado->nivel_riesgo) == 'III') selected @endif>Riesgo III -
                                    2.436%</option>
                                <option value="IV" @if (old('nivel_riesgo', $empleado->nivel_riesgo) == 'IV') selected @endif>Riesgo IV -
                                    4.350%</option>
                                <option value="V" @if (old('nivel_riesgo', $empleado->nivel_riesgo) == 'V') selected @endif>Riesgo V -
                                    6.960%</option>
                            </select>
                        </div>


                        {{-- </div> --}}
                    </div>
                </div>

                <div class="form-section">
                    <div class="card mb-3">
                        <div class="card-header">Puesto de trabajo</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="requir" for="cargo">Cargo</label>
                                <input type="text" id="cargo" name="cargo" class="form-control"
                                    value="{{ old('cargo', $empleado->cargo) }}" required>
                            </div>

                            <div class="form-group">
                                <label class="requir" for="area">Área</label>
                                <select id="area" name="area" class="form-control" required>
                                    <option value="administrativa" @if (old('area', $empleado->area) == 'administrativa') selected @endif>
                                        Administrativa</option>
                                    <option value="operativa" @if (old('area', $empleado->area) == 'operativa') selected @endif>Operativa
                                    </option>
                                    <option value="ventas" @if (old('area', $empleado->area) == 'ventas') selected @endif>Ventas
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="requir" for="dias_vacaciones">Días de vacaciones acumuladas</label>
                                <input type="text" id="dias_vacaciones" name="dias_vacaciones" class="form-control"
                                    value="{{ old('dias_vacaciones', $empleado->dias_vacaciones) }}" required>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <!-- Datos de pago -->
            <div class="form-section hidden" id="form3">
                <div class="card mb-3">
                    <div class="card-header">Datos de pago</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="requir" for="metodo_pago">Método de pago</label>
                            <select id="metodo_pago" name="metodo_pago" class="form-control" required>
                                <option value="pago_efectivo" @if (old('metodo_pago', $empleado->metodo_pago) == 'pago_efectivo') selected @endif>Pago en
                                    efectivo</option>
                                <option value="transferencia" @if (old('metodo_pago', $empleado->metodo_pago) == 'transferencia') selected @endif>
                                    Transferencia bancaria</option>
                                <option value="cheque_bancario" @if (old('metodo_pago', $empleado->metodo_pago) == 'cheque_bancario') selected @endif>Cheque
                                    bancario</option>
                                <option value="pago_especie" @if (old('metodo_pago', $empleado->metodo_pago) == 'pago_especie') selected @endif>Pago en
                                    especie (bonos o vales)</option>
                            </select>
                        </div>


                        <div id="transferencia_info" style="display: none;">
                            <div class="form-group">
                                <label for="banco">Banco</label>
                                <select id="banco" name="banco" class="form-control">
                                    <option value="bancamia"
                                        {{ old('banco', $empleado->banco) == 'bancamia' ? 'selected' : '' }}>Bancamía
                                    </option>
                                    <option value="bancolombia"
                                        {{ old('banco', $empleado->banco) == 'bancolombia' ? 'selected' : '' }}>Bancolombia
                                    </option>
                                    <option value="bancoomeva"
                                        {{ old('banco', $empleado->banco) == 'bancoomeva' ? 'selected' : '' }}>Bancoomeva
                                    </option>
                                    <option value="banco_agrario"
                                        {{ old('banco', $empleado->banco) == 'banco_agrario' ? 'selected' : '' }}>Banco
                                        Agrario</option>
                                    <option value="banco_av_villas"
                                        {{ old('banco', $empleado->banco) == 'banco_av_villas' ? 'selected' : '' }}>Banco
                                        AV Villas</option>
                                    <option value="banco_caja_social"
                                        {{ old('banco', $empleado->banco) == 'banco_caja_social' ? 'selected' : '' }}>Banco
                                        Caja Social</option>
                                    <option value="banco_credifinanciera"
                                        {{ old('banco', $empleado->banco) == 'banco_credifinanciera' ? 'selected' : '' }}>
                                        Banco Credifinanciera</option>
                                    <option value="banco_bogota"
                                        {{ old('banco', $empleado->banco) == 'banco_bogota' ? 'selected' : '' }}>Banco de
                                        Bogotá</option>
                                    <option value="banco_occidente"
                                        {{ old('banco', $empleado->banco) == 'banco_occidente' ? 'selected' : '' }}>Banco
                                        de Occidente</option>
                                    <option value="banco_falabella"
                                        {{ old('banco', $empleado->banco) == 'banco_falabella' ? 'selected' : '' }}>Banco
                                        Falabella</option>
                                    <option value="banco_finandina"
                                        {{ old('banco', $empleado->banco) == 'banco_finandina' ? 'selected' : '' }}>Banco
                                        Finandina</option>
                                    <option value="banco_gnb_sudameris"
                                        {{ old('banco', $empleado->banco) == 'banco_gnb_sudameris' ? 'selected' : '' }}>
                                        Banco GNB Sudameris</option>
                                    <option value="banco_jp_morgan"
                                        {{ old('banco', $empleado->banco) == 'banco_jp_morgan' ? 'selected' : '' }}>Banco
                                        J.P. MORGAN</option>
                                    <option value="banco_mundo_mujer"
                                        {{ old('banco', $empleado->banco) == 'banco_mundo_mujer' ? 'selected' : '' }}>Banco
                                        Mundo Mujer</option>
                                    <option value="banco_nu"
                                        {{ old('banco', $empleado->banco) == 'banco_nu' ? 'selected' : '' }}>Banco NU
                                    </option>
                                    <option value="banco_pichincha"
                                        {{ old('banco', $empleado->banco) == 'banco_pichincha' ? 'selected' : '' }}>Banco
                                        Pichincha</option>
                                    <option value="banco_popular"
                                        {{ old('banco', $empleado->banco) == 'banco_popular' ? 'selected' : '' }}>Banco
                                        Popular</option>
                                    <option value="banco_santander"
                                        {{ old('banco', $empleado->banco) == 'banco_santander' ? 'selected' : '' }}>Banco
                                        Santander</option>
                                    <option value="banco_serfinanza"
                                        {{ old('banco', $empleado->banco) == 'banco_serfinanza' ? 'selected' : '' }}>Banco
                                        Serfinanza</option>
                                    <option value="banco_w"
                                        {{ old('banco', $empleado->banco) == 'banco_w' ? 'selected' : '' }}>Banco W
                                    </option>
                                    <option value="bbva"
                                        {{ old('banco', $empleado->banco) == 'bbva' ? 'selected' : '' }}>BBVA</option>
                                    <option value="citibank"
                                        {{ old('banco', $empleado->banco) == 'citibank' ? 'selected' : '' }}>Citibank
                                    </option>
                                    <option value="coopcentral"
                                        {{ old('banco', $empleado->banco) == 'coopcentral' ? 'selected' : '' }}>Coopcentral
                                    </option>
                                    <option value="cooperativa_confiar"
                                        {{ old('banco', $empleado->banco) == 'cooperativa_confiar' ? 'selected' : '' }}>
                                        Cooperativa Confiar</option>
                                    <option value="cooperativa_cootramed"
                                        {{ old('banco', $empleado->banco) == 'cooperativa_cootramed' ? 'selected' : '' }}>
                                        Cooperativa Cootramed</option>
                                    <option value="cooperativa_cotrafa"
                                        {{ old('banco', $empleado->banco) == 'cooperativa_cotrafa' ? 'selected' : '' }}>
                                        Cooperativa Cotrafa</option>
                                    <option value="cooperativa_acn"
                                        {{ old('banco', $empleado->banco) == 'cooperativa_acn' ? 'selected' : '' }}>
                                        Cooperativa de Ahorro y Crédito Nacional</option>
                                    <option value="cooperativa_fa"
                                        {{ old('banco', $empleado->banco) == 'cooperativa_fa' ? 'selected' : '' }}>
                                        Cooperativa Financiera de Antioquia</option>
                                    <option value="cooperativa_uh"
                                        {{ old('banco', $empleado->banco) == 'cooperativa_uh' ? 'selected' : '' }}>
                                        Cooperativa Utrahuilca</option>
                                    <option value="cooprofesores"
                                        {{ old('banco', $empleado->banco) == 'cooprofesores' ? 'selected' : '' }}>
                                        Cooprofesores</option>
                                    <option value="davivienda"
                                        {{ old('banco', $empleado->banco) == 'davivienda' ? 'selected' : '' }}>Davivienda
                                    </option>
                                    <option value="daviplata"
                                        {{ old('banco', $empleado->banco) == 'daviplata' ? 'selected' : '' }}>Daviplata
                                    </option>
                                    <option value="mibanco"
                                        {{ old('banco', $empleado->banco) == 'mibanco' ? 'selected' : '' }}>Mibanco
                                    </option>
                                    <option value="nequi"
                                        {{ old('banco', $empleado->banco) == 'nequi' ? 'selected' : '' }}>Nequi</option>
                                    <option value="itau"
                                        {{ old('banco', $empleado->banco) == 'itau' ? 'selected' : '' }}>Itaú</option>
                                    <option value="scotibank_colpatria"
                                        {{ old('banco', $empleado->banco) == 'scotibank_colpatria' ? 'selected' : '' }}>
                                        Scotibank Colpatria</option>
                                    <option value="juriscoop"
                                        {{ old('banco', $empleado->banco) == 'juriscoop' ? 'selected' : '' }}>Juriscoop
                                    </option>
                                    <option value="dale"
                                        {{ old('banco', $empleado->banco) == 'dale' ? 'selected' : '' }}>DALE</option>
                                    <option value="crediflores"
                                        {{ old('banco', $empleado->banco) == 'crediflores' ? 'selected' : '' }}>Crediflores
                                    </option>
                                    <option value="lulo_bank"
                                        {{ old('banco', $empleado->banco) == 'lulo_bank' ? 'selected' : '' }}>Lulo Bank
                                    </option>
                                    <option value="global66"
                                        {{ old('banco', $empleado->banco) == 'global66' ? 'selected' : '' }}>Global66
                                    </option>
                                    <option value="rappipay"
                                        {{ old('banco', $empleado->banco) == 'rappipay' ? 'selected' : '' }}>RappiPay
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="numero_cuenta">Número de cuenta</label>
                                <input type="text" id="numero_cuenta" name="numero_cuenta" class="form-control"
                                    value="{{ old('numero_cuenta', $empleado->numero_cuenta) }}">
                            </div>

                            <div class="form-group">
                                <label for="tipo_cuenta">Tipo de cuenta</label>
                                <select id="tipo_cuenta" name="tipo_cuenta" class="form-control">
                                    <option value="corriente" @if (old('tipo_cuenta', $empleado->tipo_cuenta) == 'corriente') selected @endif>Corriente
                                    </option>
                                    <option value="ahorro" @if (old('tipo_cuenta', $empleado->tipo_cuenta) == 'ahorro') selected @endif>Ahorro
                                    </option>
                                    <option value="billetera_digital" @if (old('tipo_cuenta', $empleado->tipo_cuenta) == 'billetera_digital') selected @endif>
                                        Billetera digital</option>
                                </select>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="form-section">
                    <div class="card mb-3">
                        <div class="card-header">Afiliación</div>
                        <div class="card-body">
                            <div class="form-group"> <label class="requir" for="eps">EPS
                                </label> <select id="eps" data-selected="{{ old('eps', $empleado->eps) }}"
                                    name="eps" class="form-control" required>
                                </select>
                            </div>
                            <div class="form-group"> <label class="requir" for="caja_compensacion">Caja de compensación
                                </label> <select id="caja_compensacion"
                                    data-selected="{{ old('caja_compensacion', $empleado->caja_compensacion) }}"
                                    name="caja_compensacion" class="form-control" required>
                                </select>
                            </div>
                            <div class="form-group"> <label class="requir" for="fondo_pensiones">Fondo de pensiones
                                </label> <select id="fondo_pensiones" data-selected="{{ old('fondo_pensiones', $empleado->fondo_pensiones) }}" name="fondo_pensiones" class="form-control"
                                    required>
                                </select>
                            </div>
                            <div class="form-group"> <label class="requir" for="fondo_cesantias">Caja de compensación
                                </label> <select id="fondo_cesantias" data-selected="{{ old('fondo_cesantias', $empleado->fondo_cesantias) }}" name="fondo_cesantias" class="form-control"
                                    required>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <button class="btn btn-secondary btn-style" id="prevButton" onclick="prevForm()">Atrás</button>
                <button class="btn btn-primary btn-style" id="nextButton" onclick="nextForm()">Siguiente</button>
                <button type="submit" class="btn btn-success btn-style" id="submitButton" style="display: none;">Guardar</button>
            </div>

            <p class="mt-3">Los campos marcados con * son obligatorios</p>
        </form>

    </div>

@endsection
<script type="text/javascript" src="{{ asset('js/forms/empleado-form.js') }}"></script>
