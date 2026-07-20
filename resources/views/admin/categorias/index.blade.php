@extends('layouts.app')
@section('content')
<h1>Categorías</h1>
<table>
@foreach($categories as $cat)
<tr><td>{{ $cat->name }}</td></tr>
@endforeach
</table>
@endsection