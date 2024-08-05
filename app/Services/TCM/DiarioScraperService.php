<?php

declare (strict_types = 1);

namespace App\Services\TCM;

use App\Repositories\TCM\ContasRepository;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Storage;

class DiarioScraperService
{
    public static function getAllDiario(): array
    {
        $links = ContasRepository::getDiario();   
        return $links->json();
    }

    public static function getPdfDiario(array $diario): array
    { 
        $url = "https://egbanet.egba.ba.gov.br/tcm/portal/edicoes/download/" . $diario['id'];
        $pdfContent = file_get_contents($url);
        $fileName = 'Diario_TCM/edicao_' . $diario['numero'] . '.pdf';
        Storage::disk('public')->put($fileName, $pdfContent);

        return [];
    }
}