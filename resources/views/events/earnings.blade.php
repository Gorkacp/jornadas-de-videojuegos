
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ganancias</h1>
    <p>Las ganancias totales de los eventos son: €{{ number_format($earnings, 2) }}</p>
</div>
@endsection