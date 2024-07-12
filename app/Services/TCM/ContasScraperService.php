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
        $anos = ["2019", "2020", "2021", "2022", "2023"];
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
                'exercicio' => $crawler->filter('label:contains("Exercício:") + span')->text(),
                'transitado_em_julgado' => $crawler->filter('label:contains("Transitado em Julgado:") + span')->text(),
                'publicacao' => $crawler->filter('label:contains("Publicação:") + span')->text(),
                'pdfs' => $crawler->filter('li.list_item_content')->each(function (Crawler $node) {
                    $link = $node->filter('a')->attr('href');
                    $title = $node->filter('a span')->text();
                    return [
                        'link' => $link,
                        'title' => $title
                    ];
                })
            ];

            $pareceres[] = $parecer;
        }
      
        return $pareceres;
    }
}
