@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $speaker->name }}</h1>
    @if ($speaker->photo)
        <img src="{{ asset('storage/' . $speaker->photo) }}" alt="{{ $speaker->name }}" width="200">
    @endif
    <div class="mt-3">
        <h3>Experiencia</h3>
        <p>{{ $speaker->expertise }}</p>
    </div>
    <div class="mt-3">
        <h3>Redes Sociales</h3>
        <p>{{ $speaker->social_links }}</p>
    </div>
    @auth
        @if (Auth::user()->role === 'admin')
            <a href="{{ route('speakers.edit', $speaker->id) }}" class="btn btn-warning">Editar</a>
            <form action="{{ route('speakers.destroy', $speaker->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        @endif
    @endauth
</div>
@endsection