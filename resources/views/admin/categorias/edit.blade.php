@extends('layouts.app')
@section('content')
<h1>Editar Categoría</h1>
<form method="POST" action="{{ route('categorias.update', $category) }}">
@csrf @method('PUT')
<input name="name" value="{{ $category->name }}" required>
<button type="submit">Actualizar</button>
</form>
@endsection