@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3 my-5">
            <h2 class="mb-3">Raspagem da CGM</h2>
            <p>Este conteudo é coletado totalmente dos informes do site da CGM - Salvador. Aqui está sempre atualizado os 10 informes mais recentes.</p>
        </div>
        <div class="col-md-9">
            <div class="d-flex flex-column flex-md-row gap-4 py-md-4 align-items-center justify-content-center">
                <div class="list-group">
                    @foreach ($resultado as $value)
                    <a href="{{ $value['link'] }}" target="_blank" class="list-group-item list-group-item-action d-flex gap-3 py-2" aria-current="true">
                        <div class="d-flex gap-2 w-100 justify-content-between">
                            <div>
                                <h6 class="mb-0 text-capitalize fw-bold">{{ $value['name'] }}</h6>
                                <p class="mb-0 opacity-75">{{ $value['category'] }}</p>
                            </div>
                            <small class="opacity-50 text-nowrap">{{ $value['date'] }} de {{ $value['month'] }}</small>
                        </div>
                    </a>
                    @endforeach
                    <nav aria-label="Page navigation example" class="mt-2">
                        <ul class="pagination justify-content-end">
                          <li class="page-item disabled">
                            <a class="page-link">Previous</a>
                          </li>
                          <li class="page-item"><a class="page-link" href="#">1</a></li>
                          <li class="page-item"><a class="page-link" href="#">2</a></li>
                          <li class="page-item"><a class="page-link" href="#">3</a></li>
                          <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                          </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection