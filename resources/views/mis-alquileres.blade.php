@extends('layouts.app')
@section('content')
<h1>Mis Alquileres</h1>
@foreach($rentals as $rental)
    <div>
        <p>Estado: {{ $rental->status }}</p>
        <p>Total: ${{ $rental->total_price }}</p>
    </div>
@endforeach
@endsection