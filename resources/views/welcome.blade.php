<!-- filepath: /D:/Xampp/htdocs/jornadas-de-videojuegos/resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jornadas de Videojuegos</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }
        .btn {
            margin: 5px;
        }
        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }
        .links a {
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header text-center">
            <h1>Jornadas de Videojuegos</h1>
        </div>
        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    <span>Bienvenido, {{ Auth::user()->name }}</span>
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar Sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">Iniciar Sesión</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-secondary">Registrarse</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="text-center">
            <a href="{{ route('events.index') }}" class="btn btn-primary">Ver Eventos</a>
            <a href="{{ route('speakers.index') }}" class="btn btn-secondary">Ver Ponentes</a>
            @auth
                <a href="{{ route('assistants.create') }}" class="btn btn-success">Registrar en un Evento</a>
                <a href="{{ route('assistants.index') }}" class="btn btn-info">Mis Eventos Registrados</a>
                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('usuario.index') }}" class="btn btn-warning">Gestión de Usuarios</a>
                    <a href="{{ route('events.earnings') }}" class="btn btn-success">Ver Ganancias</a>
                @endif
            @endauth
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>