@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Eventos</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (auth()->check() && auth()->user()->role == 'admin')
        <a href="{{ route('events.create') }}" class="btn btn-primary mb-3">Crear Evento</a>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Tipo</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
                <th>Capacidad Máxima</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
                <tr>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->description }}</td>
                    <td>{{ $event->type }}</td>
                    <td>{{ $event->start_time }}</td>
                    <td>{{ $event->end_time }}</td>
                    <td>{{ $event->max_attendees }}</td>
                    <td>
                        @if (auth()->check() && auth()->user()->role == 'admin')
                            <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection