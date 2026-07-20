@extends('layouts.app')
@section('content')
<h1>Solicitudes</h1>
@foreach($rentals as $rental)
<div>
<p>Cliente: {{ $rental->client->name }}</p>
<p>Estado: {{ $rental->status }}</p>
</div>
@endforeach
@endsection