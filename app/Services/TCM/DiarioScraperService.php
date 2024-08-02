<?php

declare (strict_types = 1);

namespace App\Services\TCM;

use App\Repositories\TCM\ContasRepository;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;

class DiarioScraperService
{
    public static function Diario(): array
    {
        $links = ContasRepository::getDiario();
        
        return $links->json();
    }
}