@extends('layouts.app')

@section('title', 'Editar Categoría')

@section('content')
<h1><i class="fas fa-edit"></i> Editar Categoría</h1>

<form action="{{ route('categorias.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Descripción</label>
        <textarea name="description" id="description" class="form-control" rows="3">{{ $category->description }}</textarea>
    </div>
    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Actualizar</button>
    <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection