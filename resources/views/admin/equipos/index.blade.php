@extends('layouts.app')

@section('title', 'Gestión de Equipos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-boxes"></i> Equipos</h1>
    <a href="{{ route('equipos.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nuevo Equipo
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Código</th>
                <th>Categoría</th>
                <th>Precio/día</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($equipment as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>${{ number_format($item->daily_price, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge bg-{{ $item->status === 'available' ? 'success' : ($item->status === 'rented' ? 'warning text-dark' : 'danger') }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('equipos.edit', $item->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('equipos.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este equipo?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @if($item->status !== 'maintenance')
                            <form action="{{ route('equipo.maintenance', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-secondary btn-sm" title="Poner en mantenimiento">
                                    <i class="fas fa-wrench"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No hay equipos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection