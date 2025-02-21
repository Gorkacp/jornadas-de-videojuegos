
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ponentes</h1>
    @if(Auth::user()->role == 'admin')
        <a href="{{ route('speakers.create') }}" class="btn btn-success mb-3">Crear Ponente</a>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Foto</th>
                <th>Experiencia</th>
                <th>Redes Sociales</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($speakers as $speaker)
                <tr>
                    <td>{{ $speaker->name }}</td>
                    <td>
                        @if($speaker->photo)
                            <img src="{{ asset('storage/' . $speaker->photo) }}" alt="{{ $speaker->name }}" width="50">
                        @endif
                    </td>
                    <td>{{ $speaker->expertise }}</td>
                    <td>
                        @if(is_array($speaker->social_links))
                            @foreach($speaker->social_links as $platform => $link)
                                @if($link)
                                    <a href="{{ $link }}" target="_blank" class="btn btn-link">
                                        @if($platform == 'facebook')
                                            Facebook
                                        @elseif($platform == 'twitter')
                                            Twitter
                                        @elseif($platform == 'instagram')
                                            Instagram
                                        @else
                                            {{ ucfirst($platform) }}
                                        @endif
                                    </a><br>
                                @endif
                            @endforeach
                        @else
                            {{ $speaker->social_links }}
                        @endif
                    </td>
                    <td>
                        @if(Auth::user()->role == 'admin')
                            <a href="{{ route('speakers.edit', $speaker->id) }}" class="btn btn-primary">Editar</a>
                            <form action="{{ route('speakers.destroy', $speaker->id) }}" method="POST" style="display:inline;">
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