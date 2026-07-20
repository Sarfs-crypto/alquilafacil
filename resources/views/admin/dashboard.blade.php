@extends('layouts.app')
@section('content')
<h1>Dashboard Admin</h1>
<p>Total Equipos: {{ $total }}</p>
<p>Disponibles: {{ $disponibles }}</p>
@endforeach
@endsection