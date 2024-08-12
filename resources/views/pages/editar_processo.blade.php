@extends('app')

@section('content')
<div class="container">
    <a class="btn btn-primary btn-sm mt-4" href="{{ route('index_processos') }}">< Lista de processos</a>
    <div class="row">
        <div class="col-md-4">
            <h2 class="mt-5 fw-bold">Processo {{ $processo["codigo"] }}</h2>
            <h6 class="my-3 text-uppercase">Menções ao processo:</h6>
            @foreach ($processo->diarios as $diario)
            <span class="badge text-bg-primary"><a href="{{ Storage::url('Diario_TCM/edicao_' . $diario['codigo'] . '.pdf') }}" class="link-light text-decoration-none" target="_blank">DOE - {{$diario->codigo}}</a></span>
            @endforeach
        </div>
        <div class="col-md-8">
            <div class="mt-5 p-5 card shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                <form action="{{ route("update_processos", $processo['id']) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" rows="6" name="descricao">{{ $processo["descricao"] }}</textarea>
                    </div>
                    <select class="form-select" aria-label="Default select example">
                        <option {{ $processo['status'] == 1 ? "selected" : "" }} value="1">Ainda em observação</option>
                        <option {{ $processo['status'] == 0 ? "selected" : "" }} value="0">Observação inativa</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success mt-4 fw-bold">Atualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
