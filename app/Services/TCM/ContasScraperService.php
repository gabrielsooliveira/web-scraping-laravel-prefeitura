<?php

declare (strict_types = 1);

namespace App\Services\TCM;

use App\Repositories\TCM\ContasRepository;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;

class ContasScraperService
{
    public static function Parecer($data): array
    {
        $resultado = ContasRepository::getInfoParecer($data);
        dd($resultado->body());
        return $resultado->json();
    }
}
