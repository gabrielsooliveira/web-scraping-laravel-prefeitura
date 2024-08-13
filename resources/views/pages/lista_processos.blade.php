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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="processoAddModalLabel">Cadastro do Processo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route("store_processos") }}" method="post">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="data_publicacao" class="form-label fw-semibold">Data de publicação</label>
                            <input class="form-control" id="data_publicacao" name="data_publicacao" type="date">
                        </div>
                        <div class="col-md-8">
                            <label for="conselheiro" class="form-label fw-semibold">Conselheiro</label>
                            <input class="form-control" id="conselheiro" name="conselheiro" type="text">
                        </div>
                        <div class="col-md-6">
                            <label for="local_pr_tcm" class="form-label fw-semibold">Localização do processo TCM</label>
                            <input class="form-control" id="local_pr_tcm" name="local_pr_tcm" type="text">
                        </div>
                        <div class="col-md-6">
                            <label for="local_pr_tcm" class="form-label fw-semibold">Tipo de Processo</label>
                            <select id="tipo_public" class="form-select" name="tipo_public">
                                <option value="0">Aposentadoria</option>
                                <option value="1">Auditoria</option>
                                <option value="2">Adiantamento</option>
                                <option value="3">Concurso Público</option>
                                <option value="4">Prestação de Contas</option>
                                <option value="5">Denúncia</option>
                                <option value="6">Pensão</option>
                                <option value="7">Termo de Ocorrência</option>
                                <option value="8">Medida Cautelar</option>
                                <option value="9">Recursos Repassados</option>
                                <option value="10">Representação</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="descricao" class="form-label fw-semibold">Descrição</label>
                            <textarea class="form-control" id="descricao" rows="6" name="descricao">{{ $processo["descricao"] }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="descricao" class="form-label fw-semibold">Status</label>
                            <select class="form-select" aria-label="Default select example">
                                <option {{ $processo['status'] == 1 ? "selected" : "" }} value="1">Ainda em analise</option>
                                <option {{ $processo['status'] == 0 ? "selected" : "" }} value="0">Analise inativa</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tipo_public" class="form-label fw-semibold">Tipo de Publicação</label>
                            <select id="tipo_public" class="form-select" name="tipo_public">
                                <option value="1">Edital (DOE)</option>
                                <option value="0">E-TCM</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="julgamento" class="form-label fw-semibold">Foi julgado?</label>
                            <select id="julgamento" class="form-select" name="julgamento">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="recurso" class="form-label fw-semibold">Entrou em recurso?</label>
                            <select id="recurso" class="form-select" name="recurso">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="trans_julgamento" class="form-label fw-semibold">Transito em julgado?</label>
                            <select id="trans_julgamento" class="form-select" name="trans_julgamento">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="observacoes" class="form-label fw-semibold">Observações</label>
                            <textarea class="form-control" id="observacoes" rows="3" name="observacoes">{{ $processo["observacoes"] }}</textarea>
                        </div>
                        <div class="col-12">
                            <label for="encaminhamento_cgm" class="form-label fw-semibold">Encaminhamento CGM</label>
                            <textarea class="form-control" id="encaminhamento_cgm" rows="3" name="encaminhamento_cgm">{{ $processo["encaminhamento_cgm"] }}</textarea>
                        </div>
                        <div class="col-12">
                            <label for="encaminhamento_cgm" class="form-label fw-semibold">Resumo das decisões</label>
                            <textarea class="form-control" id="encaminhamento_cgm" rows="5" name="encaminhamento_cgm">{{ $processo["encaminhamento_cgm"] }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="recurso" class="form-label fw-semibold">Determinação ao Prefeito</label>
                            <select id="recurso" class="form-select" name="recurso">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="trans_julgamento" class="form-label fw-semibold">Determinação ao Controle Interno</label>
                            <select id="trans_julgamento" class="form-select" name="trans_julgamento">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
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
