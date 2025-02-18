@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Ponente</h1>
    <form action="{{ route('speakers.update', $speaker->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $speaker->name }}" required>
        </div>
        <div class="form-group">
            <label for="photo">Foto</label>
            <input type="file" name="photo" id="photo" class="form-control">
            @if ($speaker->photo)
                <img src="{{ asset('storage/' . $speaker->photo) }}" alt="{{ $speaker->name }}" width="100">
            @endif
        </div>
        <div class="form-group">
            <label for="expertise">Experiencia</label>
            <textarea name="expertise" id="expertise" class="form-control" required>{{ $speaker->expertise }}</textarea>
        </div>
        <div class="form-group">
            <label for="social_links">Redes Sociales</label>
            <input type="text" name="social_links" id="social_links" class="form-control" value="{{ $speaker->social_links }}">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection