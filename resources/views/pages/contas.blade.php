@extends('app')

@section('content')
<div class="container">
    <h2 class="mt-5">Raspagem da TCM</h2>
    <p>Este conteudo é coletado totalmente do TCM para verificar se foi dado o parecer de contas da prefeitura de Salvador.</p>

    <div class="d-flex align-items-start col-12">
        <div class="nav flex-column nav-pills col-2 me-4" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            @foreach ($resultado as $item)
            <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="v-pills-{{ $item['exercicio'] }}-tab" data-bs-toggle="pill" data-bs-target="#v-pills-{{ $item['exercicio'] }}" type="button" role="tab" aria-controls="v-pills-{{ $item['exercicio'] }}" aria-selected=" {{ $loop->first ? 'true' : 'false' }}">{{ $item['exercicio'] }}</button>
            @endforeach
        </div>
        <div class="tab-content col-9" id="v-pills-tabContent">
            @foreach ($resultado as $key => $item)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="v-pills-{{ $item['exercicio'] }}" role="tabpanel" aria-labelledby="v-pills-{{ $item['exercicio'] }}-tab" tabindex="{{ $key }}">
                <div class="my-2 card p-4">
                    Gestor: {{ $item['gestor'] ? $item['gestor'] : 'NÃO INFORMADO' }}
                    <br>
                    Exercício: {{ $item['exercicio'] }}
                    <br>
                    Data de Publicação: {{ $item['publicacao'] ? $item['publicacao'] : 'NÃO INFORMADO' }}
                    <br>
                    Transitado em Julgado: {{ $item['transitado_em_julgado']  }}
                    <br>
                    Última Decisão do TCM: {{ $item['decisaoTCM'] }}
                    <br>
                    <ul class="list-group list-group-flush mt-3">
                    @foreach ($item['pdfs'] as $pdf)
                        <li class="list-group-item"><a href="https://www.tcm.ba.gov.br/{{ $pdf['link'] }}" target="_blank">{{ $pdf['title'] }}</a></li>
                    @endforeach
                    </ul>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection