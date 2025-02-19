<!-- filepath: /D:/Xampp/htdocs/jornadas-de-videojuegos/resources/views/assistants/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mis Eventos Registrados</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table">
    
        <thead>
            <tr>
                <th>Evento</th>
                <th>Capacidad Disponible</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assistants as $assistant)
                <tr>
                    <td>{{ $assistant->event ? $assistant->event->title : 'Evento no encontrado' }}</td>
                    <td>{{ $assistant->event ? $assistant->event->available_capacity : 'N/A' }}</td>
                    <td>
                        <form action="{{ route('assistants.destroy', $assistant->id) }}" method="POST" style="display:inline;">
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
@endsection