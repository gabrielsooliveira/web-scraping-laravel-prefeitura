@extends('app')

@section('content')
<div class="container">
   <div class="mt-5">
        <nav aria-label="Page navigation example" class="mb-2">
            <ul class="pagination justify-content-end m-0 p-0">
                <li class="page-item">
                    <a class="page-link link-dark {{ $resultado['paginacao']['atual'] === 0 ? 'disabled' : '' }}" href="{{ route('diario_oficial') }}"><< Início</a>
                </li>
                <li class="page-item">
                    <a class="page-link link-dark {{ $resultado['paginacao']['atual'] === 0 ? 'disabled' : '' }}" href="{{ route('diario_oficial', $resultado['paginacao']['anterior']) }}"><< Anterior</a>
                </li>
                <li class="page-item">
                    <a class="page-link link-dark {{ $resultado['paginacao']['proximo'] === null ? 'disabled' : '' }}" href="{{ route('diario_oficial', $resultado['paginacao']['proximo']) }}">Próximo >></a>
                </li>
                <li class="page-item">
                    <a class="page-link link-dark {{ $resultado['paginacao']['proximo'] === null ? 'disabled' : '' }}" href="{{ route('diario_oficial', $resultado['paginacao']['fim']) }}">Fim >></a>
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
                @foreach ($resultado['diarios'] as $value)
                <tr>
                    <th scope="row">{{ $value['title'] }}</th>
                    <td>{{ date('d/m/Y', strtotime($value['date'])) }}</td>
                    <td></td>
                    <td><a type="button" class="btn btn-primary btn-sm" href="{{ $value['link'] }}" target="_blank">Visualizar</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
   </div>
</div>
@endsection