@extends('app')

@section('content')
<div class="container">
    <h2 class="mt-5">Raspagem da TCM</h2>
    <p>Este conteudo é coletado totalmente do TCM para verificar se foi dado o parecer de contas da prefeitura de Salvador.</p>

    <div class="card shadow p-3 my-3 rounded">
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col" onclick="sortTable(0)" width="140"><a href="#" class="pe-auto text-decoration-none link-dark">Exercício <i class="bi bi-chevron-expand"></i></a></th>
                        <th scope="col" onclick="sortTable(1)" width="140"><a href="#" class="pe-auto text-decoration-none link-dark">Local<i class="bi bi-chevron-expand"></i></a></th>
                        <th scope="col" onclick="sortTable(2)" width="800"><a href="#" class="pe-auto text-decoration-none link-dark">Gestor<i class="bi bi-chevron-expand"></i></a></th>
                        <th scope="col" width="260">Data de Publicação</th>
                        <th scope="col" width="260">Transitado em Julgado</th>
                        <th scope="col" width="300">Última Decisão do TCM</th>
                        <th scope="col" width="130">PDF's</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($resultado as $key => $item)
                        @foreach ($item as $local => $value)
                        <tr class="{{ $value['publicacao'] === 'NÃO INFORMADO' ? 'table-success' : '' }}">
                            <td scope="row">{{ $key }}</td>
                            <td>{{ $local }}</td>
                            <td>{{ $value['gestor'] ? $value['gestor'] : 'NÃO INFORMADO' }}</td>
                            <td>{{ $value['publicacao'] ? $value['publicacao'] : 'NÃO INFORMADO' }}</td>
                            <td>{{ $value['transitado_em_julgado']  }}</td>
                            <td>{{ $value['decisaoTCM'] }}</td>
                            <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $key }}{{ $local }}">Ver</button></td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @foreach ($resultado as $key => $item)
        @foreach ($item as $local => $value)
        <div class="modal fade" id="exampleModal{{ $key }}{{ $local }}" tabindex="-1" aria-labelledby="exampleModalLabel{{ $key }}{{ $local }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">PDF de exercício de {{ $key }} - {{  $local }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group list-group-flush">
                        @foreach ($value['pdfs'] as $pdf)
                            <li class="list-group-item"><a href="https://www.tcm.ba.gov.br/{{ $pdf['link'] }}" target="_blank" class="text-decoration-none">{{ $pdf['title'] }}</a></li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endforeach
</div>
@endsection

@push('scripts')
<script>
let sortOrder = {};

function sortTable(columnIndex) {
    const table = document.querySelector("table");
    const tbody = table.tBodies[0];
    const rows = Array.from(tbody.querySelectorAll("tr"));

    sortOrder[columnIndex] = !sortOrder[columnIndex];

    const sortedRows = rows.sort((a, b) => {
        const aText = a.cells[columnIndex].textContent.trim();
        const bText = b.cells[columnIndex].textContent.trim();

        if (isNaN(aText) || isNaN(bText)) {
            return sortOrder[columnIndex] ? aText.localeCompare(bText) : bText.localeCompare(aText);
        } else {
            return sortOrder[columnIndex] ? aText - bText : bText - aText;
        }
    });

    while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild);
    }

    tbody.append(...sortedRows);
}
</script>
@endpush