<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PayrollPro')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="stylesheet" href="{{ asset('css/layouts/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/empleados/create.css') }}">
    <link rel="stylesheet" href="{{ asset('css/empleados/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/empleados/show.css') }}">

    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">

    <link rel="stylesheet" href="{{ asset('css/liquidaciones/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/liquidaciones/show.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="{{ asset('images/pato.svg') }}" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Host+Grotesk:ital,wght@0,300..800;1,300..800&family=Koulen&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Doto:wght@100..900&family=Host+Grotesk:ital,wght@0,300..800;1,300..800&family=Koulen&family=Tiny5&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

</head>

<body>
    <div class="main-container">
        {{-- Bontón para ocultar la barra de navegación en móviles --}}
        <button class="sidebar-toggle" onclick="toggleSidebar()"><i class="bi bi-list-nested"></i></button>

        {{-- div sidebar --}}
        <div class="sidebar">
            <div class="logo">
                <img src="{{ asset('images/pato.svg') }}" alt="PayrollPro Logo">
                <h2>PayrollPro</h2>
            </div>
            {{-- lista de vainos --}}
            <ul class="nav-list">
                @foreach ($menuItems as $item)
                <li>
                    <a href="{{ $item['url'] }}">
                        <i class="{{ $item['icon'] }}"></i> {{ $item['name'] }}
                    </a>
                </li>
                @endforeach
            </ul>
            {{-- botón de modo oscuro --}}
            {{-- <button id="modeToggle" class="mode-toggle" onclick="toggleMode()">🌙 Modo Oscuro</button> --}}
            <!-- Add a form that will submit the logout request -->
            <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            <!-- Button to trigger the logout form -->
            <button id="modeToggle" class="mode-toggle btn-style"
                onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                Salir
            </button>

            <!-- Button to show user profile -->
            <a href="{{ route('empleados.showself') }}" class="btn btn-primary btn-style">Perfil</a>

        </div>


        <div class="content">
            {{-- alert --}}
            <div class="toast-container position-fixed top-0 end-0 p-3">
                <div id="liveToast" class="toast align-items-center text-bg-danger border-0" role="alert"
                    aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body" id="toastMessage">
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            </div>
            @yield('content')
        </div>
    </div>

    @yield('scripts')
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('liveToast');
            const toastMessage = document.getElementById('toastMessage');
            toastMessage.textContent = "{{ session('success') }}";

            toast.classList.remove('text-bg-danger');
            toast.classList.add('text-bg-success');

            const toastBootstrap = new bootstrap.Toast(toast);
            toastBootstrap.show();
        });
    </script>
    @endif

    @if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('liveToast');
            const toastMessage = document.getElementById('toastMessage');
            toastMessage.textContent = "{{ session('error') }}";

            toast.classList.remove('text-bg-success');
            toast.classList.add('text-bg-danger');

            const toastBootstrap = new bootstrap.Toast(toast);
            toastBootstrap.show();
        });
    </script>
    @endif


</body>

</html>