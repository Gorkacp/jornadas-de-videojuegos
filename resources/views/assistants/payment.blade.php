
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pago de Entrada</h1>
    <p>Nombre: {{ $assistant->name }}</p>
    <p>Correo Electrónico: {{ $assistant->email }}</p>
    <p>Evento: {{ $assistant->event->title }}</p>
    <p>Tipo de Asistencia: {{ ucfirst($assistant->attendance_type) }}</p>
    <p>Precio: €{{ number_format($assistant->event->price, 2) }}</p>
    <form method="POST" action="{{ route('assistants.processPayment') }}">
        @csrf
        <input type="hidden" name="assistant_id" value="{{ $assistant->id }}">
        <input type="hidden" name="total" value="{{ number_format($assistant->event->price, 2, '.', '') }}">
        <button type="submit" class="btn btn-success">Pagar</button>
    </form>
</div>
@endsection