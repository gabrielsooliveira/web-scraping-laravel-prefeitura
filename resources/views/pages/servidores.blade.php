@extends('app')

@section('content')
<div class="container">
    <div class="my-5">
        <h2>Raspagem do Portal Transparencia</h2>
        {{ var_dump($resultado['dados']) }}
    </div>
</div>
@endsection