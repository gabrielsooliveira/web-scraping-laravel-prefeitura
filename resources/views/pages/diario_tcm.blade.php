@extends('app')

@section('content')
<div class="container">
    <h2 class="mt-4">Diarios Oficiais do TCM</h2>
    <div class="mt-2">
         <nav aria-label="Page navigation example" class="mb-2 d-flex">
            <span class="mt-2">{{ $resultados->currentPage() }} de {{ $resultados->lastPage() }} Páginas</span>
            <ul class="pagination ms-auto p-0">
                <li class="page-item">
                    <a class="page-link link-dark {{ $resultados->currentPage() === 1 ? 'disabled' : '' }}" href="{{ $resultados->url(1) }}">Primeira</a>
                </li>
                <li class="page-item">
                    <a class="page-link link-dark {{ $resultados->currentPage() === 1 ? 'disabled' : '' }}" href="{{ $resultados->previousPageUrl() }}">< Anterior</a>
                </li>
                <li class="page-item">
                    <a class="page-link link-dark {{ $resultados->currentPage() === $resultados->lastPage() ? 'disabled' : '' }}" href="{{ $resultados->nextPageUrl() }}">Proxima ></a>
                </li>
                <li class="page-item">
                    <a class="page-link link-dark {{ $resultados->currentPage() === $resultados->lastPage() ? 'disabled' : '' }}" href="{{ $resultados->url($resultados->lastPage()) }}">Última</a>
                </li>
            </ul>
        </nav>
        <table class="table">
             <thead>
                <tr>
                    <th scope="col">DOE</th>
                    <th scope="col">Data de publicação</th>
                    <th scope="col">Processos Mencionados</th>
                    <th scope="col">PDF</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($resultados as $diario)
                <tr>
                    <th scope="row">DOE - {{ $diario['codigo'] }}</th>
                    <td>{{ date('d/m/Y', strtotime($diario['data_publicacao'])) }}</td>
                    <td>
                        @foreach ($diario->processos as $processo)
                        <span class="badge text-bg-primary"><a href="{{ route("show_processos", $processo['id']) }}" class="link-light text-decoration-none">{{$processo->codigo}}</a></span>
                        @endforeach
                    </td>
                    <td><a type="button" class="btn btn-primary btn-sm" href="{{ Storage::url('Diario_TCM/edicao_' . $diario['codigo'] . '.pdf') }}" target="_blank">Visualizar</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
