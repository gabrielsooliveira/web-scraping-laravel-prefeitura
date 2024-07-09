@extends('app')

@section('content')
<div>
    <h2>Raspagem do Portal Transparencia</h2>
    {{ dd($resultado['dados']) }}
</div>
@endsection