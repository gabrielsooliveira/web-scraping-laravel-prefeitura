@extends('app')

@section('content')
<div class="container">
    <a class="btn btn-primary btn-sm mt-4 fw-semibold" href="{{ route('index_processos') }}">< Lista de processos</a>
    <div class="row">
        <div class="col-md-4">
            <h2 class="mt-5 fw-bold">Processo {{ $processo["codigo"] }}</h2>
            @foreach ($processo->diarios as $diario)
            <div>
                @if ($diario['dias_diferenca'] !== null)
                    <div>
                       Periodo até ser mecionado: {{ $diario['dias_diferenca'] }} dias
                    </div>
                @endif
                <span class="badge text-bg-primary">
                    <a href="{{ Storage::url('Diario_TCM/edicao_' . $diario['codigo'] . '.pdf') }}" class="link-light text-decoration-none" target="_blank">DOE - {{$diario->codigo}}</a>
                </span>
                Publicado em: {{ date('d/m/Y', strtotime($diario['data_publicacao'])) }}
            </div>
            @endforeach
        </div>
        <div class="col-md-8">
            <div class="mt-5 p-5 card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                <form action="{{ route("update_processos", $processo['id']) }}" method="post">
                    @csrf
                    @method('PUT')
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
                    <button type="submit" class="btn btn-sm btn-success mt-4 fw-bold">Atualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
