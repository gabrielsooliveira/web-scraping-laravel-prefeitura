@extends('app')

@section('content')
<div class="container">
    <div class="mt-5 card p-4" style="height:600px">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">DOM</th>
                        <th scope="col">Data de publicação</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resultados["itens"] as $key => $value)
                    <tr>
                        <td>DOM - {{ $value['numero'] }}</td>
                        <td>{{ $value['data'] }}</td>
                        <td>
                            <a type="button" class="btn btn-primary btn-sm" href="https://egbanet.egba.ba.gov.br/tcm/ver-pdf/{{ $value['id'] }}/#/p:1/e:{{ $value['id'] }}" target="_blank">PDF</a>
                            <a type="button" class="btn btn-warning btn-sm" href="https://egbanet.egba.ba.gov.br/tcm/ver-flip/{{ $value['id'] }}/#/p:1/e:{{ $value['id'] }}" target="_blank">FLIP</a>
                            <a type="button" class="btn btn-danger btn-sm" href="https://egbanet.egba.ba.gov.br/tcm/ver-html/{{ $value['id'] }}/#/p:1/e:{{ $value['id'] }}" target="_blank">HTML</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection