@extends('layouts.app')

@section('title', 'Editar Equipo')

@section('content')
<h1><i class="fas fa-edit"></i> Editar Equipo: {{ $equipment->name }}</h1>

<form action="{{ route('equipos.update', $equipment->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="category_id" class="form-label">Categoría</label>
                <select name="category_id" id="category_id" class="form-select" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $equipment->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $equipment->name }}" required>
            </div>
            <div class="mb-3">
                <label for="code" class="form-label">Código</label>
                <input type="text" name="code" id="code" class="form-control" value="{{ $equipment->code }}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="daily_price" class="form-label">Precio por día</label>
                <input type="number" name="daily_price" id="daily_price" class="form-control" step="0.01" value="{{ $equipment->daily_price }}" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Imagen</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                @if($equipment->image)
                    <img src="{{ asset('storage/' . $equipment->image) }}" width="100" class="mt-2">
                @endif
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ $equipment->description }}</textarea>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Actualizar</button>
    <a href="{{ route('equipos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection