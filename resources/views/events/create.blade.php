<!-- filepath: /D:/Xampp/htdocs/jornadas-de-videojuegos/resources/views/events/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Evento</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('events.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>
        </div>
        <div class="form-group">
            <label for="type">Tipo</label>
            <select name="type" id="type" class="form-control" required>
                <option value="conference" {{ old('type') == 'conference' ? 'selected' : '' }}>Conferencia</option>
                <option value="workshop" {{ old('type') == 'workshop' ? 'selected' : '' }}>Taller</option>
            </select>
        </div>
        <div class="form-group">
            <label for="start_time">Hora de Inicio</label>
            <input type="datetime-local" name="start_time" id="start_time" class="form-control" value="{{ old('start_time') }}" required>
        </div>
        <div class="form-group">
            <label for="end_time">Hora de Fin</label>
            <input type="datetime-local" name="end_time" id="end_time" class="form-control" value="{{ old('end_time') }}" required>
        </div>
        <div class="form-group">
            <label for="max_attendees">Capacidad</label>
            <input type="number" name="max_attendees" id="max_attendees" class="form-control" value="{{ old('max_attendees') }}" required>
        </div>
        <div class="form-group">
            <label for="speaker_id">Ponente</label>
            <select name="speaker_id" id="speaker_id" class="form-control" required>
                @foreach($speakers as $speaker)
                    <option value="{{ $speaker->id }}" {{ old('speaker_id') == $speaker->id ? 'selected' : '' }}>{{ $speaker->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Crear Evento</button>
    </form>
</div>
@endsection