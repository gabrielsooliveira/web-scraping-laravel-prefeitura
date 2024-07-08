<?php

declare (strict_types = 1);

namespace App\Services\PortalTransparencia;

use App\Repositories\PortalTransparencia\ServidoresRepository;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;

class ServidoresScraperService
{
    public static function Servidores(): array
    {
        $data = [
            'ativo' => null,
            'nome' => "Gutemberg",
            'cargo' => "",
            'cpf' => "",
            'lotacao' => "",
            'orgao' => "",
            'tipo' => "",
            'vinculo' => "",
            'dataInicio' => '2024-01-01T00:00:00Z',
            'dataFim' => '2024-07-07T03:00:00Z',
        ];

        $resultado = ServidoresRepository::getServidoresList($data);

        dd($resultado->json());
    }
}
