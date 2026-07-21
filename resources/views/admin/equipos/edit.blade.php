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
                <label for="category_id" class="form-label">Categoría <span class="text-danger">*</span></label>
                <select name="category_id" id="category_id" class="form-select" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $equipment->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $equipment->name }}" required>
            </div>
            <div class="mb-3">
                <label for="code" class="form-label">Código <span class="text-danger">*</span></label>
                <input type="text" name="code" id="code" class="form-control" value="{{ $equipment->code }}" required>
                <small class="text-muted">Debe ser único.</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="daily_price" class="form-label">Precio por día <span class="text-danger">*</span></label>
                <input type="number" name="daily_price" id="daily_price" class="form-control" step="0.01" value="{{ $equipment->daily_price }}" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Imagen</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                @if($equipment->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $equipment->image) }}" width="100" alt="Imagen actual">
                    </div>
                @endif
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ $equipment->description }}</textarea>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Actualizar</button>
        <a href="{{ route('equipos.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Cancelar</a>
    </div>
</form>
@endsection