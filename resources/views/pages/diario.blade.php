@extends('app')

@section('content')
<div class="container">
   <div class="mt-4">
        <nav aria-label="Page navigation example" class="mb-2 d-flex">
            <span class="mt-2">{{ $resultados->currentPage() }} de {{ $resultados->lastPage() }} Páginas</span>
            <ul class="pagination ms-auto p-0">
                <li class="page-item">
                    <a class="page-link link-dark {{ $resultados->currentPage() === 1 ? 'disabled' : '' }}" href="{{ $resultados->previousPageUrl() }}"> << Anterior </a>
                </li>
                <li class="page-item">
                    <a class="page-link link-dark {{ $resultados->currentPage() === $resultados->lastPage() ? 'disabled' : '' }}" href="{{ $resultados->nextPageUrl() }}"> Proxima >> </a>
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
                    <th scope="row">{{ $value['codigo'] }}</th>
                    <td>{{ date('d/m/Y', strtotime($value['data_publicacao'])) }}</td>
                    <td></td>
                    <td><a type="button" class="btn btn-primary btn-sm" href="{{ Storage::url('DOM/' . $value['url']) }}" target="_blank">Visualizar</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
   </div>
</div>
@endsectionj