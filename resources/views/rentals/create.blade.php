@extends('layouts.app')

@section('title', 'Nueva Solicitud de Alquiler')

@section('content')
<h1><i class="fas fa-cart-plus"></i> Nueva Solicitud</h1>

<form action="{{ route('rental.store') }}" method="POST">
    @csrf

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="equipment_ids" class="form-label">Selecciona los equipos</label>
                <select name="equipment_ids[]" id="equipment_ids" class="form-select" multiple size="5" required>
                    @foreach($equipment as $item)
                        <option value="{{ $item->id }}" {{ request('equipo') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }} - ${{ number_format($item->daily_price, 0, ',', '.') }}/día
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">Mantén presionado Ctrl (Windows) o Cmd (Mac) para seleccionar varios.</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="start_date" class="form-label">Fecha de inicio</label>
                <input type="date" name="start_date" id="start_date" class="form-control" min="{{ date('Y-m-d') }}" required>
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">Fecha de fin</label>
                <input type="date" name="end_date" id="end_date" class="form-control" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
            </div>
            <div class="mb-3">
                <label for="notes" class="form-label">Notas (opcional)</label>
                <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-check"></i> Crear solicitud
            </button>
            <a href="{{ route('catalogo') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Cancelar
            </a>
        </div>
    </div>
</form>
@endsection