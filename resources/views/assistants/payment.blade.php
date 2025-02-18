<!-- filepath: /D:/Xampp/htdocs/jornadas-de-videojuegos/resources/views/assistants/payment.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pago de Entrada</h1>
    <p>Nombre: {{ $assistant->name }}</p>
    <p>Correo Electrónico: {{ $assistant->email }}</p>
    <p>Evento: {{ $assistant->event->title }}</p>
    <p>Tipo de Asistencia: {{ ucfirst($assistant->attendance_type) }}</p>
    <form method="POST" action="{{ route('paypal.createPayment') }}">
        @csrf
        <input type="hidden" name="assistant_id" value="{{ $assistant->id }}">
        <button type="submit" class="btn btn-success">Pagar con PayPal</button>
    </form>
</div>
@endsection