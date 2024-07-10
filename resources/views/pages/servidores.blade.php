@extends('app')

@section('content')
<div class="container">
    <div class="my-5">
        <h2>Raspagem do Portal Transparencia</h2>
        <div class="table-responsive">
            <table class="table table-sm">
                <thead class="text-capitalize">
                    <tr>
                        <th scope="col">CPF</th>
                        <th scope="col">nome</th>
                        <th scope="col">cargo</th>
                        <th scope="col">tipo</th>
                        <th scope="col">vinculo</th>
                        <th scope="col">orgão</th>
                        <th scope="col">lotação</th>
                        <th scope="col">admissão</th>
                        <th scope="col">desligamento</th>
                        <th scope="col">carga horaria</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($resultado['dados'] as $value)
                    <tr>
                        <th scope="row">{{ $value['cpfMascarado'] }}</th>
                        <td>{{ $value['nome'] }}</td>
                        <td>{{ $value['cargo'] }}</td>
                        <td>{{ $value['tipo'] }}</td>
                        <td>{{ $value['vinculo'] }}</td>
                        <td>{{ $value['orgao'] }}</td>
                        <td>{{ $value['lotacao'] }}</td>
                        <td>{{ date('d/m/Y', strtotime($value['dataAdmissao'])) }}</td>
                        <td>{{ $value['dataDesligamento'] }}</td>
                        <td>{{ $value['cargaHorariaSemanal'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection