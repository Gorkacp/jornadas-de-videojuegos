<!-- filepath: /D:/Xampp/htdocs/jornadas-de-videojuegos/resources/views/speakers/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Ponente</h1>
    <form action="{{ route('speakers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="photo">Foto</label>
            <input type="file" name="photo" id="photo" class="form-control">
        </div>
        <div class="form-group">
            <label for="expertise">Experiencia</label>
            <textarea name="expertise" id="expertise" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="social_links[facebook]">Facebook</label>
            <input type="url" name="social_links[facebook]" id="social_links[facebook]" class="form-control">
        </div>
        <div class="form-group">
            <label for="social_links[twitter]">Twitter</label>
            <input type="url" name="social_links[twitter]" id="social_links[twitter]" class="form-control">
        </div>
        <div class="form-group">
            <label for="social_links[instagram]">Instagram</label>
            <input type="url" name="social_links[instagram]" id="social_links[instagram]" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
    </form>
</div>
@endsection