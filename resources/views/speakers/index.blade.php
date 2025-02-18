@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ponentes</h1>
    @auth
        @if (Auth::user()->role === 'admin')
            <a href="{{ route('speakers.create') }}" class="btn btn-primary">Crear Ponente</a>
        @endif
    @endauth
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Foto</th>
                <th>Experiencia</th>
                <th>Redes Sociales</th>
                @auth
                    @if (Auth::user()->role === 'admin')
                        <th>Acciones</th>
                    @endif
                @endauth
            </tr>
        </thead>
        <tbody>
            @foreach ($speakers as $speaker)
                <tr>
                    <td>{{ $speaker->name }}</td>
                    <td><img src="{{ asset('storage/' . $speaker->photo) }}" alt="{{ $speaker->name }}" width="100"></td>
                    <td>{{ $speaker->expertise }}</td>
                    <td>{{ $speaker->social_links }}</td>
                    @auth
                        @if (Auth::user()->role === 'admin')
                            <td>
                                <a href="{{ route('speakers.edit', $speaker->id) }}" class="btn btn-warning">Editar</a>
                                <form action="{{ route('speakers.destroy', $speaker->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        @endif
                    @endauth
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection