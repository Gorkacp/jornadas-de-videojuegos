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
            <label for="social_links">Redes Sociales</label>
            <input type="text" name="social_links" id="social_links" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
    </form>
</div>
@endsection