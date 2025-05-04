@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <style>
        body {
            background-color: var(--color-bg-light);
            margin: 0;
            padding: 0;
            color: var(--color-text-light);
        }

        .dark-mode body {
            background-color: var(--color-bg-dark);
            color: var(--color-text-dark);
        }

        .container {
            max-width: 1000px !important;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: var(--color-sb-light);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: left;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .dark-mode .header {
            background-color: var(--color-sb-dark);
        }

        .header h1 {
            margin: 0;
            color: var(--color-text-light);
        }

        .dark-mode .header h1 {
            color: var(--color-text-dark);
        }

        .header p {
            margin: 5px 0;
            color: var(--color-text-light);
        }

        .dark-mode .header p {
            color: var(--color-text-dark);
        }

        .summary {
            display: flex;
            justify-content: space-between;
            background-color: var(--color-sb-light);
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .dark-mode .summary {
            background-color: var(--color-sb-dark);
            color: var(--color-text-dark);
        }

        .summary div {
            text-align: center;
        }

        .summary div p {
            margin: 5px 0;
            color: var(--color-text-light);
        }

        .dark-mode .summary div p {
            color: var(--color-text-dark);
        }

        .summary div .status {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
            font-size: 14px;
        }

        .cards {
            display: flex;
            gap: 20px;
        }

        .card {
            background-color: var(--color-sb-light);
            border-radius: 8px;
            padding: 20px;
            flex: 1;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .dark-mode .card {
            background-color: var(--color-sb-dark);
            color: var(--color-text-dark);
        }

        .card h3 {
            margin: 0 0 15px;
            font-size: 18px;
            color: var(--color-text-light);
        }

        .dark-mode .card h3 {
            color: var(--color-text-dark);
        }

        .card p {
            color: var(--color-text-light);
            font-size: 14px;
        }

        .dark-mode .card p {
            color: var(--color-text-dark);
        }

        .button {
            background-color: var(--color-primary-light);
            color: var(--color-text-dark);
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            display: block;
            text-align: center;
            margin: 20px 0;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .dark-mode .button {
            background-color: var(--color-primary-dark);
            color: var(--color-text-light);
        }

        .button:hover {
            background-color: #e3879b;
            color: var(--color-bg-light);
            border-color: #e3879b;
        }

        .dark-mode .button:hover {
            background-color: #db6d89;
            color: var(--color-text-dark);
        }

        .indicators,
        .events {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .indicator,
        .event {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-radius: 8px;
            background-color: var(--color-step-light);
            font-size: 14px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .dark-mode .indicator,
        .dark-mode .event {
            background-color: var(--color-step-dark);
            color: var(--color-text-dark);
        }

        .chart {
            height: 200px;
            background-color: #f2f7ff;
            border-radius: 8px;
            text-align: center;
            line-height: 200px;
            color: #666;
            font-size: 16px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .dark-mode .chart {
            background-color: var(--color-form-dark);
            color: var(--color-text-dark);
        }
    </style>

    <div class="container big">
        <div class="header">
            {{-- <h1>¡Buenas tardes, {{ $user->name }}!</h1> --}}
            <p>Aquí puedes ver tus resúmenes y accesos rápidos.</p>
        </div>

        <div class="summary">
            <div>
                <p>Última nómina creada</p>
                <h2>{{ $user->last_payroll ?? '0' }}</h2>
            </div>
            <div>
                <p>No. empleados</p>
                <h2>{{ $user->email ?? '0' }}</h2>
            </div>
            <div>
                <p>Estado</p>
                <span class="status">{{ $user->status ?? 'Pendiente' }}</span>
            </div>
            <div>
                <p>Progreso de emisión</p>
                <h2>{{ $user->emission_progress ?? '-' }}</h2>
            </div>
            <div>
                <a href="#" class="button">Ir a emitir</a>
            </div>
        </div>

        <div class="cards">
            <div class="card">
                <h3>Emisiones de nómina</h3>
                <p>{{ $user->payrolls_message ?? 'Aún no tienes nóminas emitidas.' }}</p>
                <a href="#" class="button">+ Nueva emisión</a>
            </div>

            <div class="card indicators">
                <h3>Indicadores</h3>
                <div class="indicator">
                    <span>Auxilio de transporte</span>
                    <span>$162.000 COP</span>
                </div>
                <div class="indicator">
                    <span>Salario mínimo</span>
                    <span>$1.300.000 COP</span>
                </div>
                <div class="indicator">
                    <span>Salario integral</span>
                    <span>$16.900.000 COP</span>
                </div>
            </div>

            <div class="card events">
                <h3>Eventos</h3>
                <div class="event">
                    <span>Emisión de Nómina</span>
                    <span>Ir →</span>
                </div>
                <p>No tienes más eventos próximos.</p>
            </div>
        </div>

        <div class="card chart">
            <h3>Contratación por mes</h3>
            <p>Gráfica (Placeholder)</p>
        </div>
    </div>
@endsection
