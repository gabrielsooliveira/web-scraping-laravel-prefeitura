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
                    <a class="page-link link-dark {{ $resultados->currentPage() === 1 ? 'disabled' : '' }}" href="{{ $resultados->previousPageUrl() }}"> << Anterior </a>
                </li>
                <li class="page-item">
                    <a class="page-link link-dark {{ $resultados->currentPage() === $resultados->lastPage() ? 'disabled' : '' }}" href="{{ $resultados->nextPageUrl() }}"> Proxima >> </a>
                </li>
                <li class="page-item">
                    <a class="page-link link-dark {{ $resultados->currentPage() === $resultados->lastPage() ? 'disabled' : '' }}" href="{{ $resultados->url($resultados->lastPage()) }}">Última</a>
                </li>
             </ul>
         </nav>
         <table class="table">
             <thead>
                 <tr>
                     <th scope="col">DOM</th>
                     <th scope="col">Data de publicação</th>
                     <th scope="col">Informações</th>
                     <th scope="col">PDF</th>
                 </tr>
             </thead>
             <tbody>
                 @foreach ($resultados as $value)
                 <tr>
                     <th scope="row">DOM - {{ $value['codigo'] }}</th>
                     <td>{{ date('d/m/Y', strtotime($value['data_publicacao'])) }}</td>
                     <td>
                     @if ($value->notificacao)
                     <span class="badge text-bg-primary">Menção a prefeitura de Salvador existente</span>
                     @endif
                     </td>
                     <td><a type="button" class="btn btn-primary btn-sm" href="{{ Storage::url('Diario_TCM/edicao_' . $value['codigo'] . '.pdf') }}" target="_blank">Visualizar</a></td>
                 </tr>
                 @endforeach
             </tbody>
         </table>
    </div>
 </div>
@endsection
