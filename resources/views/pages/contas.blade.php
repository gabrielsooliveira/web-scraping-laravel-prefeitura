@extends('app')

@section('content')
<div class="container">
    <h2 class="mt-5">Raspagem da TCM</h2>
    <p>Este conteudo é coletado totalmente do TCM para verificar se foi dado o parecer de contas da prefeitura.</p>

    @foreach ($resultado as $item)
        <div class="my-2 card p-4">
            {{ $item['gestor'] }}
            <br>
            {{ $item['exercicio'] }}
            <br>
            {{ $item['publicacao'] }}
        </div>
    @endforeach
</div>
@endsection