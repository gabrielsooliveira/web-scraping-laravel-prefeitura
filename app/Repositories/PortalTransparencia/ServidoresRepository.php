<?php

declare (strict_types = 1);

namespace App\Repositories\PortalTransparencia;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ServidoresRepository
{
    public static function getServidoresList($data): Response
    {
        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json, text/plain, */*',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive'
        ])->post("https://transparencia.salvador.ba.gov.br/api/api/servidores/gridAgrupada", $data);
    }

    public static function getDetalhe($data): Response
    {
        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json, text/plain, */*',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive'
        ])->post("https://transparencia.salvador.ba.gov.br/api/api/servidores/detalhamento", $data);
    }
}
