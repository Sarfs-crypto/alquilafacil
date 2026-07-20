@extends('layouts.app')

@section('content')
<h1>Mis Propiedades</h1>
<a href="{{ route('properties.create') }}">Nueva Propiedad</a>
<table>
    <tr><th>Título</th><th>Precio</th><th>Acciones</th></tr>
    @foreach($properties as $property)
    <tr><td>{{ $property->title }}</td><td>${{ $property->price_per_night }}</td><td>Editar</td></tr>
    @endforeach
</table>
@endsection