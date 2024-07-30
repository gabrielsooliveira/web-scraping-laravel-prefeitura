@extends('app')

@section('content')
<div class="container">
   <div class="mt-4">
        <nav aria-label="Page navigation example" class="mb-2 d-flex">
            {{-- @if($resultado['paginacao']['fim'] == null)
            <span class="mt-2">{{ $resultado['paginacao']['atual']/10 + 1 }} de {{ $resultado['paginacao']['atual']/10 + 1 }} Páginas</span>
            @else
            <span class="mt-2">{{ $resultado['paginacao']['atual']/10 + 1 }} de {{ $resultado['paginacao']['fim']/10 + 1 }} Páginas</span>
            @endif --}}
            <ul class="pagination ms-auto p-0">
                <li class="page-item">
                    <a class="page-link link-dark" href="{{ $resultados->previousPageUrl() }}"> << </a>
                </li>
                <li class="page-item">
                    <a class="page-link link-dark" href="{{ $resultados->nextPageUrl() }}"> >> </a>
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
@endsection