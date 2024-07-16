@extends('app')

@section('content')
<div class="container">
    <h2 class="mt-5">Raspagem da TCM</h2>
    <p>Este conteudo é coletado totalmente do TCM para verificar se foi dado o parecer de contas da prefeitura de Salvador.</p>

    <div class="d-flex align-items-start col-12 my-3">
        <div class="nav flex-column nav-pills col-3 pe-4" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            @foreach ($resultado as $key => $item)
            <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="v-pills-{{ $key }}-tab" data-bs-toggle="pill" data-bs-target="#v-pills-{{ $key }}" type="button" role="tab" aria-controls="v-pills-{{ $key }}" aria-selected=" {{ $loop->first ? 'true' : 'false' }}">{{ $key }}</button>
            @endforeach
        </div>
        <div class="tab-content col-9 ps-4" id="v-pills-tabContent">
            @foreach ($resultado as $key => $item)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="v-pills-{{ $key }}" role="tabpanel" aria-labelledby="v-pills-{{ $key }}-tab" tabindex="{{ $key }}">
                <div class="my-2 card p-4">
                    Gestor: {{ $item['PREFEITURA']['gestor'] ? $item['PREFEITURA']['gestor'] : 'NÃO INFORMADO' }}
                    <br>
                    Exercício: {{ $key }}
                    <br>
                    Data de Publicação: {{ $item['PREFEITURA']['publicacao'] ? $item['publicacao'] : 'NÃO INFORMADO' }}
                    <br>
                    Transitado em Julgado: {{ $item['PREFEITURA']['transitado_em_julgado']  }}
                    <br>
                    Última Decisão do TCM: {{ $item['PREFEITURA']['decisaoTCM'] }}
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