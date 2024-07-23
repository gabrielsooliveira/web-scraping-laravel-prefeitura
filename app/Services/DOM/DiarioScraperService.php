<?php

declare (strict_types = 1);

namespace App\Services\DOM;

use App\Repositories\DOM\DiarioRepository;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;

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
}