<?php

declare (strict_types = 1);

namespace App\Services\DOM;

use App\Repositories\DOM\DiarioRepository;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;
use Smalot\PdfParser\Parser;

class DiarioScraperService
{
    public static function Diario(int $value): array
    {
        $resultado = DiarioRepository::getPdfs($value);
        if ($resultado->failed()) {
            logs()->debug("Falha ao fazer a consulta à repository.", ['status' => $resultado->status(), 'msg' => $resultado->json()]);
            return [];
        }
        
        $html = $resultado->getBody()->getContents();
        $crawler = new Crawler($html);

        $conteudo['diarios'] = $crawler->filter('.dmarticlesfilter_results_row')->each(function (Crawler $node) {
            $date = $node->filter('#dmarticlesfilter_results_date')->text();
            $title = trim(explode(' - ', $node->filter('a')->text())[1]);

            $href = $node->filter('a')->attr('href');
            preg_match('/id=(\d+)/', $href, $matches);
            $id = $matches[1] ?? '0000';
            
            $pdfLink = self::LinkPdf($id);
            /*
            $pdfInfo = self::getPdfInfo($pdfLink);
            */
            return [
                'date' => $date,
                'title' => $title,
                'link' => $pdfLink,
            ];
        });

        $conteudo['paginacao'] = [
            'anterior' => null,
            'atual' => $value,
            'proximo' => $value + 10,
            'fim' => null,
        ];

        $crawler->filter('.paginacao a')->each(function (Crawler $node) use (&$conteudo) {
            $title = strtolower($node->attr('title'));
            $href = $node->attr('href');

            preg_match('/limitstart=(\d+)/', $href, $matches);
            $limitstart = $matches[1] ?? null;

            if ($title === 'anterior') {
                $conteudo['paginacao']['anterior'] = $limitstart == 1 ? 0 : $limitstart;
            }if ($title === 'fim') {
                $conteudo['paginacao']['fim'] = $limitstart;
            }
        });
        
        return $conteudo;
    }

    private static function LinkPdf(string $id): string
    {
        $resultado = DiarioRepository::getlinkPdf($id);
        $html = $resultado->getBody()->getContents();
        $crawler = new Crawler($html);

        $link = $crawler->filter('h3 a')->attr('href');

        return $link;
    }

    private static function getPdfInfo(string $url): array
    {
        $client = HttpClient::create();
        $response = $client->request('GET', $url);
        $pdfContent = $response->getContent();

        $parser = new Parser();
        $pdf = $parser->parseContent($pdfContent);

        $text = $pdf->getText();

        // Extrair parágrafos que começam com "RESOLVE:" e capturar o texto até o próximo parágrafo
        preg_match_all('/(?:exonera[^\n]*\n(?:[^\n]*\n?){0,1}[^\n]*(?:\n|$)){1,2}/is', $text, $matches);
        $dataNames = [];
        $filtros = [
            "/desde \d{2}\/\d{2}\/\d{4},\s*([^\n,]+?)(?:,|$)/u", 
            "/a partir de (\d{2}\/\d{2}\/\d{4})[^\n]*o servidor\s*([^\n,]+),/",
            "/desde (\d{2}\/\d{2}\/\d{4})[^\n]*a servidora\s*([\s\S]*?)(?:,\s*|$)/i",
            "/desde (\d{2}\/\d{2}\/\d{4})[^\n]*o servidor\s*([\s\S]*?)(?:,\s*|$)/i",
        ];

        foreach ($filtros as $filtro) {
            // Executa a expressão regular
            preg_match_all($filtro, $text, $matches, PREG_SET_ORDER);
    
            // Processa cada correspondência encontrada
            foreach ($matches as $match) {
                // Verifica e ajusta os índices para extrair a data e o nome
                $date = isset($match[1]) ? trim($match[1]) : null;
                $name = isset($match[2]) ? trim(preg_replace('/\s+/', ' ', $match[2])) : null;
    
                // Adiciona os dados ao array de resultados
                $dataNames[] = [
                    'data' => $date,
                    'nome' => $name,
                ];
            }
        }

        dd($dataNames, $text);
        return [
            'resolves' => $matches[0], // Parágrafos que começam com "RESOLVE:" e texto subsequente
        ];
    }
}