@extends('layouts.app')
@section('content')
<h1>{{ $equipment->name }}</h1>
<p>Precio: ${{ $equipment->daily_price }}</p>
<form method="POST" action="{{ route('rentals.store') }}">
    @csrf
    <input type="hidden" name="equipment_ids[]" value="{{ $equipment->id }}">
    <button type="submit">Solicitar Alquiler</button>
</form>
@endsection