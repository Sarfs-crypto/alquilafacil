@extends('layouts.app')
@section('content')
<h1>{{ $equipment->name }}</h1>
<p>Precio: ${{ $equipment->daily_price }}/día</p>
<form method="POST" action="{{ route('rentals.store') }}">
@csrf
<input type="hidden" name="equipment_ids[]" value="{{ $equipment->id }}">
<input type="date" name="start_date">
<input type="date" name="end_date">
<button type="submit">Alquilar</button>
</form>
@endsection