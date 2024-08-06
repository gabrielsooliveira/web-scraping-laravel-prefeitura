@extends('app')

@section('content')
<div class="container">
    <h2 class="mt-5">Raspagem da TCM</h2>
    <p>Este conteudo é coletado totalmente do TCM para verificar se foi dado o parecer de contas dos orgãos descentralizados de Salvador.</p>

    <div class="d-flex align-items-start col-12 my-3">
        <div class="nav flex-column nav-pills col-3 pe-4" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            @foreach ($resultado as $key => $item)
            <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="v-pills-{{ $key }}-tab" data-bs-toggle="pill" data-bs-target="#v-pills-{{ $key }}" type="button" role="tab" aria-controls="v-pills-{{ $key }}" aria-selected=" {{ $loop->first ? 'true' : 'false' }}">{{ $key }}</button>
            @endforeach
        </div>
        <div class="tab-content col-9 ps-4" id="v-pills-tabContent">
            @foreach ($resultado as $key => $items)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="v-pills-{{ $key }}" role="tabpanel" aria-labelledby="v-pills-{{ $key }}-tab" tabindex="{{ $key }}">
                <div class="accordion" id="accordionExample{{ $key }}">
                    @foreach ($items as $empresa => $empresa_data)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $empresa }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse{{ $empresa }}">
                                {{ $empresa }}
                            </button>
                        </h2>
                        <div id="collapse{{ $empresa }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#accordionExample{{ $empresa }}">
                          <div class="accordion-body">
                            <div class="my-2 card p-4">
                                Gestor: {{ $empresa_data['gestor'] ? $empresa_data['gestor'] : 'NÃO INFORMADO' }}
                                <br>
                                Exercício: {{ $key }}
                                <br>
                                Data de Publicação: {{ $empresa_data['publicacao'] ? $empresa_data['publicacao'] : 'NÃO INFORMADO' }}
                                <br>
                                Transitado em Julgado: {{ $empresa_data['transitado_em_julgado']  }}
                                <br>
                                Última Decisão do TCM: {{ $empresa_data['decisaoTCM'] }}
                                <br>
                                <ul class="list-group list-group-flush mt-3">
                                @if(!empty($empresa_data['pdfs']))
                                    @foreach ($empresa_data['pdfs'] as $indice => $pdf)
                                    <li class="list-group-item"><a href="https://www.tcm.ba.gov.br/{{ $pdf['link'] }}" target="_blank" class="text-decoration-none">{{ $pdf['title'] }}</a></li>
                                    @endforeach
                                @else
                                    <li class="list-group-item">Nenhum PDF encontrado</li>
                                @endif
                                </ul>
                            </div>
                          </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
