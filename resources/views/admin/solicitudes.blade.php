@extends('layouts.app')
@section('content')
<h1>Solicitudes de Alquiler</h1>
@foreach($rentals as $rental)
<div>
<p>Cliente: {{ $rental->client->name ?? 'N/A' }}</p>
<p>Estado: {{ $rental->status }}</p>
<a href="{{ route('rental.approve', $rental) }}">Aprobar</a>
</div>
@endforeach
@endsection