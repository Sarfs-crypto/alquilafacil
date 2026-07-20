@extends('layouts.app')
@section('content')
<h1>Nueva Categoría</h1>
<form method="POST" action="{{ route('categorias.store') }}">
@csrf
<input name="name" placeholder="Nombre" required>
<button type="submit">Guardar</button>
</form>
@endsection