@extends('layouts.app')

@section('content')
<h1>Crear Propiedad</h1>
<form method="POST" action="{{ route('properties.store') }}">
    @csrf
    <input name="title" placeholder="Título" required>
    <textarea name="description" placeholder="Descripción"></textarea>
    <input name="location" placeholder="Ubicación" required>
    <input name="price_per_night" type="number" placeholder="Precio por noche" required>
    <button type="submit">Guardar</button>
</form>
@endsection