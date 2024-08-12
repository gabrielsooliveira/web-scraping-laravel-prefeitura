@extends('app')

@section('content')
<div class="container">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h2 class="mt-5 mb-0">Lista de Processos</h2>
            <p>Processos que estão sendo observados pela controladoria geral do município de Salvador.</p>
        </div>
        <button type="button" class="btn btn-primary btn-sm mt-5 fw-bold" data-bs-toggle="modal" data-bs-target="#processoAddModal">
           + Adicionar Processo
        </button>
    </div>

    <div class="mt-2">
        <nav aria-label="Page navigation example" class="mb-2 d-flex">
            <span class="mt-2">{{ $processos->currentPage() }} de {{ $processos->lastPage() }} Páginas</span>
            <ul class="pagination ms-auto p-0">
               <li class="page-item">
                   <a class="page-link link-dark {{ $processos->currentPage() === 1 ? 'disabled' : '' }}" href="{{ $processos->url(1) }}">Primeira</a>
               </li>
               <li class="page-item">
                   <a class="page-link link-dark {{ $processos->currentPage() === 1 ? 'disabled' : '' }}" href="{{ $processos->previousPageUrl() }}">< Anterior</a>
               </li>
               <li class="page-item">
                   <a class="page-link link-dark {{ $processos->currentPage() === $processos->lastPage() ? 'disabled' : '' }}" href="{{ $processos->nextPageUrl() }}">Proxima ></a>
               </li>
               <li class="page-item">
                   <a class="page-link link-dark {{ $processos->currentPage() === $processos->lastPage() ? 'disabled' : '' }}" href="{{ $processos->url($processos->lastPage()) }}">Última</a>
               </li>
            </ul>
        </nav>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Codigo do processo</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($processos as $processo)
                <tr>
                    <th scope="row">{{ $processo['codigo'] }}</th>
                    <td class="text-truncate">{{ $processo["descricao"] ? $processo["descricao"]  : "Processo sem descrição" }}</td>
                    <td class="text-truncate">{{ $processo['status'] == 1 ? "Ainda em observação" : "Observação inativa" }}</td>
                    <td>
                        <a class="btn btn-sm btn-warning fw-bold" href="{{ route("show_processos", $processo['id']) }}">Editar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
   </div>

    <div class="modal fade" id="processoAddModal" tabindex="-1" aria-labelledby="processoAddModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="processoAddModalLabel">Cadastro do Processo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route("store_processos") }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="codigoP" class="form-label">Codigo do processo</label>
                        <input type="text" class="form-control" id="codigoP" name="codigoP">
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" rows="6" name="descricao"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
