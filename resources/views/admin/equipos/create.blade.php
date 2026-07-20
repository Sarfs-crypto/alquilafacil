@extends('layouts.app')
@section('content')
<h1>Nuevo Equipo</h1>
<form method="POST" action="{{ route('equipos.store') }}">
@csrf
<input name="name" placeholder="Nombre" required>
<input name="code" placeholder="Código" required>
<input name="daily_price" type="number" placeholder="Precio diario" required>
<select name="category_id">
@foreach($categories as $cat)
<option value="{{ $cat->id }}">{{ $cat->name }}</option>
@endforeach
</select>
<button type="submit">Guardar</button>
</form>
@endsection