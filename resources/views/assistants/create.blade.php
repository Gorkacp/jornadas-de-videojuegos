<!-- filepath: /D:/Xampp/htdocs/jornadas-de-videojuegos/resources/views/assistants/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar en un Evento</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('assistants.store') }}">
        @csrf

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="event_id">Evento</label>
            <select class="form-control" id="event_id" name="event_id" required>
                @foreach($events as $event)
                    <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                        {{ $event->title }} (Capacidad disponible: {{ $event->available_capacity }})
                    </option>
                @endforeach
            </select>
            @error('event_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="attendance_type">Tipo de Asistencia</label>
            <select class="form-control" id="attendance_type" name="attendance_type" required>
                <option value="presencial" {{ old('attendance_type') == 'presencial' ? 'selected' : '' }}>Presencial</option>
                <option value="virtual" {{ old('attendance_type') == 'virtual' ? 'selected' : '' }}>Virtual</option>
                <option value="gratuita" {{ old('attendance_type') == 'gratuita' ? 'selected' : '' }}>Gratuita (Estudiantes)</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>
@endsection