@extends('app')

@section('content')
<div class="container">
    <h2 class="display-2 mt-5">Sobre o sistema</h2>
    <p>Um sistema de web scraping utilizando Laravel 10.10 para coletar dados dos sites da <a href="https://cgm.salvador.ba.gov.br/" class="text-decoration-none" target="_blank">Controladoria Geral do Município</a> e do <a href="https://transparencia.salvador.ba.gov.br/#/" class="text-decoration-none" target="_blank">Portal da Transparência de Salvador</a>. Este sistema automatiza a extração de informações públicas, processando e armazenando dados como relatórios financeiros e despesas públicas de forma estruturada e segura. Além disso, inclui uma interface administrativa para visualização e exportação de dados, permitindo atualizações periódicas e garantindo a precisão e a transparência das informações coletadas.</p>
</div>
@endsection