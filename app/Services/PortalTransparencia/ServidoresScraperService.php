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
            'nome' => "JOU ALEXANDRE DE JESUS OLIVEIRA JUNIOR",
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
       
        return $resultado->json();
    }

    public static function DetalheServidor(): array
    {
        $data = [
            'cpf' => "kNBdMb0s5aIp5QOg1p17GSU6WqRjpNEDz1iPtXisKcs=",
            'dataFim' => "2024-07-07T03:00:00.000Z",
            'dataInicio' => "2024-01-01T03:00:00.000Z",
            'nome' => "Gabriel Souza Oliveira"
        ];
        
        $resultado = ServidoresRepository::getDetalhe($data);

        return $resultado->json();
    }
}
