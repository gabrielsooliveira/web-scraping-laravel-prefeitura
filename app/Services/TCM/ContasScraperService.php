<?php

declare (strict_types = 1);

namespace App\Services\TCM;

use App\Repositories\TCM\ContasRepository;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;

class ContasScraperService
{
    public static function Parecer(): array
    {
        $anos = ["2015", "2016", "2017", "2018", "2019", "2020", "2021", "2022", "2023"];
        $pareceres = [];

        foreach ($anos as $value) {
            $data = [
                'ano' => $value,
                'ent' => "P",
                'muni' => "00334",
                'des' => null,
                'contaanual' => null,
                'B1' => "Pesquisar"
            ];
    
            $resultado = ContasRepository::getInfoParecer($data);
            $conteudo = $resultado->body();
            $crawler = new Crawler($conteudo);
            
            $parecer = [
                'processo' => $crawler->filter('label:contains("Processo:") + span')->text(),
                'gestor' => $crawler->filter('label:contains("Gestor:") + span')->text(),
                'transitado_em_julgado' => $crawler->filter('label:contains("Transitado em Julgado:") + span')->text(),
                'publicacao' => $crawler->filter('label:contains("Publicação:") + span')->text(),
                'decisaoTCM' => $crawler->filter('label:contains("Última Decisão do TCM:") + span')->text(),
                'pdfs' => $crawler->filter('li.list_item_content')->each(function (Crawler $node) {
                    $link = $node->filter('a')->attr('href');
                    $title = $node->filter('a span')->text();
                    return [
                        'link' => $link,
                        'title' => $title
                    ];
                })
            ];

            $pareceres[$value]['PREFEITURA'] = $parecer;
        }
      
        return $pareceres;
    }

    public static function ParecerDescentralizada(): array
    {
        set_time_limit(360);
        $anos = ["2015", "2016", "2017", "2018", "2019", "2020", "2021", "2022", "2023"];
        $empresas = ["ARSAL", "COGEL", "CTM", "DESAL", "FCF", "FCM", "FGM", "FMLF", "GCM", "LIMPURB", "SALTUR", "SUCOP", "TRANSALVADOR"];
        $pareceres = [];

        foreach ($anos as $value) {
            foreach ($empresas as $empresa) {
                $data = [
                    'ano' => $value,
                    'ent' => "D",
                    'muni' => null,
                    'des' => "SALVADOR:{$empresa}",
                    'contaanual' => null,
                    'B1' => "Pesquisar"
                ];
        
                $resultado = ContasRepository::getInfoParecer($data);
                $conteudo = $resultado->body();
                $crawler = new Crawler($conteudo);
                $parecer = [
                    'processo' => null,
                    'gestor' => null,
                    'transitado_em_julgado' => null,
                    'publicacao' => null,
                    'decisaoTCM' => null,
                    'pdfs' => []
                ];

                if ($crawler->filter('label:contains("Processo:") + span')->count()) {
                    $parecer['processo'] = $crawler->filter('label:contains("Processo:") + span')->text();
                }
    
                if ($crawler->filter('label:contains("Gestor:") + span')->count()) {
                    $parecer['gestor'] = $crawler->filter('label:contains("Gestor:") + span')->text();
                }
    
                if ($crawler->filter('label:contains("Transitado em Julgado:") + span')->count()) {
                    $parecer['transitado_em_julgado'] = $crawler->filter('label:contains("Transitado em Julgado:") + span')->text();
                }
    
                if ($crawler->filter('label:contains("Publicação:") + span')->count()) {
                    $parecer['publicacao'] = $crawler->filter('label:contains("Publicação:") + span')->text();
                }
    
                if ($crawler->filter('label:contains("Última Decisão do TCM:") + span')->count()) {
                    $parecer['decisaoTCM'] = $crawler->filter('label:contains("Última Decisão do TCM:") + span')->text();
                }
    
                if ($crawler->filter('li.list_item_content')->count()) {
                    $parecer['pdfs'] = $crawler->filter('li.list_item_content')->each(function (Crawler $node) {
                        $link = $node->filter('a')->attr('href');
                        $title = $node->filter('a span')->text();
                        return [
                            'link' => $link,
                            'title' => $title
                        ];
                    });
                }

                $pareceres[$value][$empresa] = $parecer;
            }
        }

        return $pareceres;
    }
}
