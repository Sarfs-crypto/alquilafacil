@extends('layouts.app')

@section('title', 'Crear Categoría')

@section('content')
<h1><i class="fas fa-plus"></i> Nueva Categoría</h1>

<form action="{{ route('categorias.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Descripción</label>
        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
        <a href="{{ route('categorias.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Cancelar</a>
    </div>
</form>
@endsection