@extends('app')

@section('content')
<div class="px-5">
    <div class="row">
        <div class="col-md-5 mt-4">
            <h2 class="mb-3">Raspagem da CGM</h2>
            <p>Este conteudo é coletado totalmente dos informes do site da CGM - Salvador. Aqui está sempre atualizado os 10 informes mais recentes.</p>
        </div>
        <div class="col-md-7">
            <div class="d-flex flex-column flex-md-row gap-4 py-md-4 align-items-center justify-content-center">
                <div class="list-group w-75">
                    @foreach ($resultado['informes'] as $value)
                    <a href="{{ $value['link'] }}" target="_blank" class="list-group-item list-group-item-action d-flex gap-3 py-2" aria-current="true">
                        <div class="d-flex gap-2 w-100 justify-content-between">
                            <div>
                                <h6 class="mb-0 text-capitalize fw-bold">{{ $value['nome'] }}</h6>
                                <p class="mb-0 opacity-75 fs-7">{{ $value['categoria'] }}</p>
                            </div>
                            <small class="opacity-50 text-nowrap">{{ $value['dia'] }} de {{ $value['mes'] }}</small>
                        </div>
                    </a>
                    @endforeach
                    <nav aria-label="Page navigation example" class="mt-2">
                        <ul class="pagination justify-content-end m-0 p-0">
                          <li class="page-item">
                            <a class="page-link link-dark {{ $resultado['paginacao']['atual'] === 1 ? 'disabled' : '' }}" href="{{ route('cgm_informes', $resultado['paginacao']['anterior']) }} "><< Anterior</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link link-dark {{ $resultado['paginacao']['proximo'] === null ? 'disabled' : '' }}" href="{{ route('cgm_informes', $resultado['paginacao']['proximo']) }}">Proximo >></a>
                          </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection