@extends('app')

@section('content')
<div class="container">
    <h2 class="mt-5">Raspagem da TCM</h2>
    <p>Este conteudo é coletado totalmente do TCM para verificar se foi dado o parecer de contas da prefeitura de Salvador.</p>

    <div class="card shadow p-3 my-3 rounded">
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Exercício</th>
                        <th scope="col">Local</th>
                        <th scope="col">Gestor</th>
                        <th scope="col">Data de Publicação</th>
                        <th scope="col">Transitado em Julgado</th>
                        <th scope="col">Última Decisão do TCM</th>
                        <th scope="col">PDF's</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($resultado as $key => $item)
                        @foreach ($item as $local => $value)
                        <tr>
                            <th scope="row">{{ $key }}</th>
                            <th scope="row">{{ $local }}</th>
                            <td>{{ $value['gestor'] ? $value['gestor'] : 'NÃO INFORMADO' }}</td>
                            <td>{{ $value['publicacao'] ? $value['publicacao'] : 'NÃO INFORMADO' }}</td>
                            <td>{{ $value['transitado_em_julgado']  }}</td>
                            <td>{{ $value['decisaoTCM'] }}</td>
                            <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $key }}{{ $local }}">Ver</button></td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @foreach ($resultado as $key => $item)
        @foreach ($item as $local => $value)
        <div class="modal fade" id="exampleModal{{ $key }}{{ $local }}" tabindex="-1" aria-labelledby="exampleModalLabel{{ $key }}{{ $local }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">PDF de exercício de {{ $key }} - {{  $local }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group list-group-flush">
                        @foreach ($value['pdfs'] as $pdf)
                            <li class="list-group-item"><a href="https://www.tcm.ba.gov.br/{{ $pdf['link'] }}" target="_blank" class="text-decoration-none">{{ $pdf['title'] }}</a></li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endforeach
</div>
@endsection