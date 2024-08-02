<?php

declare (strict_types = 1);

namespace App\Repositories\TCM;

use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class ContasRepository
{
    public static function getInfoParecer($data): Response
    {
        return Http::asForm()
        ->withHeaders([
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'Pragma' => 'no-cache',
            'Content-Type' => 'application/x-www-form-urlencoded'
        ])->withOptions(['verify' => false])->post("https://www.tcm.ba.gov.br/consulta/legislacao/decisoes/contas-anuais/detalhe-conta-anual", $data);
    }

    public static function getDiario(): Response
    {
        return Http::get("https://egbanet.egba.ba.gov.br/apifront/portal/edicoes/ultimas_edicoes.json?subtheme=tcm");
    }
}
