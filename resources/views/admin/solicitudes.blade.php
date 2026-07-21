@extends('layouts.app')

@section('title', 'Todas las Solicitudes')

@section('content')
<h1><i class="fas fa-file-invoice"></i> Solicitudes de Alquiler</h1>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($rentals->isEmpty())
    <div class="alert alert-info">No hay solicitudes registradas.</div>
@else
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Fecha inicio</th>
                    <th>Fecha fin</th>
                    <th>Equipos</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rentals as $rental)
                    <tr>
                        <td>{{ $rental->id }}</td>
                        <td>{{ $rental->client->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($rental->start_date)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($rental->end_date)->format('d/m/Y') }}</td>
                        <td>
                            @foreach($rental->items as $item)
                                <span class="badge bg-secondary">{{ $item->equipment->name }}</span>
                            @endforeach
                        </td>
                        <td>${{ number_format($rental->total_price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $rental->status === 'pending' ? 'warning text-dark' : ($rental->status === 'active' ? 'success' : ($rental->status === 'cancelled' ? 'danger' : 'secondary')) }}">
                                {{ ucfirst($rental->status) }}
                            </span>
                        </td>
                        <td>
                            @if($rental->status === 'pending')
                                <form action="{{ route('rental.approve', $rental->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('¿Aprobar este alquiler?')">
                                        <i class="fas fa-check"></i> Aprobar
                                    </button>
                                </form>
                            @elseif($rental->status === 'active')
                                <form action="{{ route('rental.return', $rental->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('¿Registrar devolución?')">
                                        <i class="fas fa-undo"></i> Devolver
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection