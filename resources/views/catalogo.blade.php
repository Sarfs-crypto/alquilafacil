@extends('layouts.app')
@section('content')
<h1>Catálogo de Equipos</h1>
@foreach($equipment as $item)
    <div>
        <h3>{{ $item->name }}</h3>
        <p>${{ $item->daily_price }}/día</p>
        <a href="{{ route('equipo.show', $item) }}">Ver</a>
    </div>
@endforeach
@endsection