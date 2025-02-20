@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Ponente</h1>
    <form action="{{ route('speakers.update', $speaker->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $speaker->name }}" required>
        </div>
        <div class="form-group">
            <label for="photo">Foto</label>
            <input type="file" name="photo" id="photo" class="form-control">
            @if($speaker->photo)
                <img src="{{ asset('storage/' . $speaker->photo) }}" alt="{{ $speaker->name }}" width="50">
            @endif
        </div>
        <div class="form-group">
            <label for="expertise">Área de experiencia</label>
            <input type="text" name="expertise" id="expertise" class="form-control" value="{{ $speaker->expertise }}" required>
        </div>
        <div class="form-group">
            <label for="social_links[facebook]">Facebook</label>
            <input type="url" name="social_links[facebook]" id="social_links[facebook]" class="form-control" value="{{ $speaker->social_links['facebook'] ?? '' }}">
        </div>
        <div class="form-group">
            <label for="social_links[twitter]">Twitter</label>
            <input type="url" name="social_links[twitter]" id="social_links[twitter]" class="form-control" value="{{ $speaker->social_links['twitter'] ?? '' }}">
        </div>
        <div class="form-group">
            <label for="social_links[instagram]">Instagram</label>
            <input type="url" name="social_links[instagram]" id="social_links[instagram]" class="form-control" value="{{ $speaker->social_links['instagram'] ?? '' }}">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
