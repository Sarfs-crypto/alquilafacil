@extends('layouts.app')
@section('content')
<h1>Nueva Solicitud</h1>
<form method="POST" action="{{ route('rentals.store') }}">
@csrf
<select name="equipment_ids[]" multiple>
@foreach($equipment as $e)
<option value="{{ $e->id }}">{{ $e->name }}</option>
@endforeach
</select>
<input type="date" name="start_date">
<input type="date" name="end_date">
<button type="submit">Solicitar</button>
</form>
@endsection