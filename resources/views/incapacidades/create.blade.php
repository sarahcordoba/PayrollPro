@extends('layouts.app')

@section('title', 'Nueva Incapacidad')

@section('content')
    <div class="container">
        <h1 class="titulito">Nueva Incapacidad</h1>
        <p>Registra la información de tu incapacidad para que sea aprobada.</p>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
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

        <form action="{{ route('incapacidades.store') }}" method="POST" id="incapacidad_form" enctype="multipart/form-data" autocomplete="off">
            @csrf

            {{-- Progress bar y pasos --}}
            <div class="progres">
                <div class="progress-bar">
                    <div class="progress-bar-fill"></div>
                </div>
                <div class="step-container">
                    <div class="step" id="step1">
                        <div class="step-indicator">1</div>
                        <div class="step-label">Información</div>
                    </div>
                    <div class="step" id="step2">
                        <div class="step-indicator">2</div>
                        <div class="step-label">Descripción</div>
                    </div>
                    <div class="step" id="step3">
                        <div class="step-indicator">3</div>
                        <div class="step-label">Soporte</div>
                    </div>
                </div>
            </div>

            {{-- Paso 1 --}}
            <div class="form-section active" id="form1">
                <div class="card mb-3">
                    <div class="card-header">Información Incapacidad</div>
                    <div class="card-body">
                        <div class="row_d">
                            <div class="form-group">
                                <label class="requir" for="fecha_contratacion">Fecha de inicio</label>
                                <input type="date" id="fecha_contratacion" name="fecha_contratacion" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="requir" for="fecha_fin_incapacidad">Fecha de finalización</label>
                                <input type="date" id="fecha_fin_incapacidad" name="fecha_fin_incapacidad" class="form-control" required>
                            </div>
                        </div>
                        <div class="row_d">
                            <div class="form-group">
                                <label class="requir" for="tipo_incapacidad">Tipo de Incapacidad</label>
                                <select name="tipo_incapacidad" class="form-control" required>
                                    <option value="enfermedad_comun">Enfermedad común</option>
                                    <option value="accidente_laboral">Accidente laboral</option>
                                    <option value="enfermedad_laboral">Enfermedad laboral</option>
                                    <option value="accidente_comun">Accidente común</option>
                                    <option value="licencia_maternidad">Licencia de maternidad</option>
                                    <option value="licencia_paternidad">Licencia de paternidad</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Paso 2 --}}
            <div class="form-section hidden" id="form2">
                <div class="card mb-3">
                    <div class="card-header">Descripción Incapacidad</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" rows="3" maxlength="1000"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Paso 3 --}}
            <div class="form-section hidden" id="form3">
                <div class="card mb-3">
                    <div class="card-header">Soporte</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="requir" for="soporte">Subir archivo de soporte</label>
                            <input type="file" name="soporte" id="soporte" class="form-control" accept=".pdf,image/*">
                            <small class="form-text text-muted">Formatos permitidos: PDF, JPG, PNG. Máx. 2MB.</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botones navegación --}}
            <div class="d-flex justify-content-between mt-3">
                <button class="btn btn-secondary btn-style" id="prevButton" onclick="prevForm()">Atrás</button>
                <button class="btn btn-primary btn-style" id="nextButton" onclick="nextForm()">Siguiente</button>
                <button type="submit" class="btn btn-success btn-style" id="submitButton" style="display: none;">Guardar</button>
            </div>

            <p class="mt-3">Los campos marcados con * son obligatorios</p>
        </form>
    </div>
@endsection

{{-- JS para avanzar pasos --}}
<script type="text/javascript" src="{{ asset('js/forms/empleado-form.js') }}"></script>
