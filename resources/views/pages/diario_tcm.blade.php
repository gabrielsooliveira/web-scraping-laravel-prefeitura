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
                        <th scope="col">PDF</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resultados["itens"] as $value)
                    <tr>
                        <th scope="row">DOM - {{ $value['numero'] }}</th>
                        <td>{{ date('d/m/Y', strtotime($value['data'])) }}</td>
                        <td><a type="button" class="btn btn-primary btn-sm" href="https://egbanet.egba.ba.gov.br/tcm/ver-pdf/{{ $value['id'] }}/#/p:1/e:{{ $value['id'] }}" target="_blank">Visualizar</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection