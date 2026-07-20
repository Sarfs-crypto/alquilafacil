@extends('layouts.app')
@section('content')
<h1>Editar Equipo</h1>
<form method="POST" action="{{ route('equipos.update', $equipment) }}">
@csrf @method('PUT')
<input name="name" value="{{ $equipment->name }}" required>
<input name="code" value="{{ $equipment->code }}" required>
<input name="daily_price" type="number" value="{{ $equipment->daily_price }}" required>
<button type="submit">Actualizar</button>
</form>
@endsection