@extends('layouts.app')
@section('content')
<h1>Equipos</h1>
<a href="{{ route('equipos.create') }}">Nuevo</a>
<table>
@foreach($equipment as $item)
<tr><td>{{ $item->name }}</td><td>{{ $item->status }}</td></tr>
@endforeach
</table>
@endsection