@extends('layouts.app')

@section('content')
<h1>Mis Reservas</h1>
<table>
    <tr><th>Propiedad</th><th>Fechas</th><th>Estado</th></tr>
    @foreach($rentals as $rental)
    <tr><td>{{ $rental->property->title ?? 'N/A' }}</td><td>{{ $rental->start_date }} - {{ $rental->end_date }}</td><td>{{ $rental->status }}</td></tr>
    @endforeach
</table>
@endsection