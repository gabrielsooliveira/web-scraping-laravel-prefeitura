@extends('app')

@section('content')
<div class="px-5">
    <div class="mt-3">
        <h2>Raspagem do Portal Transparencia</h2>
        <p>Este conteudo é coletado totalmente do portal da transparência da prefeitura de Salvador.</p>
        
        <div class="row mt-4">
            <div class="col-md-5">
                <div class="card shadow-lg p-3 mb-5 text-bg-primary rounded">
                    <div class="card-body">
                        <h6 class="fw-bold">Consulta Detalhada:</h6>
                        <form class="row g-3" action="">
                            <div class="col-lg-6">
                                <label for="dataInicio" class="form-label">Data Inicio:</label>
                                <input type="date" class="form-control" id="dataInicio" name="dataInicio">
                            </div>
                            <div class="col-lg-6">
                                <label for="dataFim" class="form-label">Data Fim:</label>
                                <input type="date" class="form-control" id="dataFim" name="dataFim">
                            </div>
                            <div class="col-lg-6">
                                <label for="ativo" class="form-label">Situação:</label>
                                <select id="ativo" class="form-select">
                                    <option name="ativo" value="">...</option>
                                    <option name="ativo" value="SIM">Ativo</option>
                                    <option name="ativo" value="NÃO">Inativo</option>
                                </select>                  
                            </div>
                            <div class="col-lg-6">
                                <label for="vinculo" class="form-label">Vínculo:</label>
                                <select id="vinculo" class="form-select">
                                    <option name="vinculo" value="">...</option>
                                    <option name="vinculo" value="AGENTE PUBLICO">AGENTE PUBLICO</option>
                                    <option name="vinculo" value="APOSENT PARLAMENTAR VEREADOR">APOSENT PARLAMENTAR VEREADOR</option>
                                    <option name="vinculo" value="APOSENTADO">APOSENTADO</option>
                                    <option name="vinculo" value="CLT">CLT</option>
                                    <option name="vinculo" value="DIRETOR ESTAT EMPR MUNICIPAL">DIRETOR ESTAT EMPR MUNICIPAL</option>
                                    <option name="vinculo" value="ESTAGIARIO">ESTAGIARIO</option>
                                    <option name="vinculo" value="ESTATUTARIO">ESTATUTARIO</option>
                                    <option name="vinculo" value="INSTITUIDOR">INSTITUIDOR</option>
                                    <option name="vinculo" value="PENSIONISTA">PENSIONISTA</option>
                                    <option name="vinculo" value="REDA">REDA</option>
                                    <option name="vinculo" value="REGIME ESPECIAL">REGIME ESPECIAL</option>
                                    <option name="vinculo" value="REGIME ESPECIAL CLT">REGIME ESPECIAL CLT</option>
                                    <option name="vinculo" value="REGIME ESPECIAL ESTATUTARIO">REGIME ESPECIAL ESTATUTARIO</option>
                                    <option name="vinculo" value="REGIME ESPECIAL OUTRA ESFERA">REGIME ESPECIAL OUTRA ESFERA</option>
                                </select> 
                            </div>
                            <div class="col-lg-6">
                                <label for="CPF" class="form-label">CPF:</label>
                                <input type="text" class="form-control" id="CPF">
                            </div>
                            <div class="col-lg-6">
                                <label for="orgao" class="form-label">Órgão:</label>
                                <select id="orgao" class="form-select">
                                    <option name="orgao" value="">...</option>
                                    <option name="orgao" value="ADESA">ADESA</option>
                                    <option name="orgao" value="AGERT">AGERT</option>
                                    <option name="orgao" value="ARSAL">ARSAL</option>
                                    <option name="orgao" value="CASA CIVIL">CASA CIVIL</option>
                                    <option name="orgao" value="CGM">CGM</option>
                                    <option name="orgao" value="COGEL">COGEL</option>
                                    <option name="orgao" value="COHAB">COHAB</option>
                                    <option name="orgao" value="COMASA">COMASA</option>
                                    <option name="orgao" value="CTS">...</option>
                                    <option name="orgao" value="DESAL">...</option>
                                    <option name="orgao" value="FCM">...</option>
                                    <option name="orgao" value="FGM">...</option>
                                    <option name="orgao" value="FMLF">...</option>
                                    <option name="orgao" value="FUMPRES CAMARA">...</option>
                                    <option name="orgao" value="">...</option>
                                    <option name="orgao" value="">...</option>
                                    <option name="orgao" value="">...</option>
                                    <option name="orgao" value="">...</option>
                                    <option name="orgao" value="">...</option>
                                    <option name="orgao" value="">...</option>
                                    <option name="orgao" value="">...</option>
                                    <option name="orgao" value="">...</option>
                                    <option name="orgao" value="">...</option>
                                    <option name="orgao" value="">...</option>
                                    <option name="orgao" value="">...</option>
                                </select>                  
                            </div>
                            <div class="col-lg-6">
                                <label for="inputEmail4" class="form-label">Lotação:</label>
                                <input type="email" class="form-control" id="inputEmail4">
                            </div>
                            <div class="col-lg-6">
                                <label for="inputEmail4" class="form-label">Cargo:</label>
                                <input type="email" class="form-control" id="inputEmail4">
                            </div>
                            <div class="col-lg-12">
                                <label for="inputEmail4" class="form-label">Nome:</label>
                                <input type="email" class="form-control" id="inputEmail4">
                            </div>
                            <div class="d-grid gap-2 d-md-block">
                                <button type="button" class="btn btn-success btn-sm">Pesquisar</button>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
            <div class="col-md-7">
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
    </div>
</div>
@endsection