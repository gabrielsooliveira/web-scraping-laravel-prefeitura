@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-5">
            <h2 class="mt-5">Processo {{ $processo["codigo"] }}</h2>
            <p>{{ $processo["descricao"] ? $processo["descricao"] : "Processo sem descrição" }}</p>
        </div>
        <div class="col-md-7">
            <div class="mt-5 p-5 card">
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
                    <button type="submit" class="btn btn-sm btn-success mt-4">Atualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
