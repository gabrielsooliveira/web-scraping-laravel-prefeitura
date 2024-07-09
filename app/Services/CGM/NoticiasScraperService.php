<?php

declare (strict_types = 1);

namespace App\Services\CGM;

use App\Repositories\CGM\NoticiasRepository;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;

class NoticiasScraperService
{
    public static function Informes($value): array
    {
        $resultado = NoticiasRepository::getConteudoInformes($value);
        if ($resultado->failed()) {
            logs()->debug("Falha ao fazer a consulta à repository.", ['status' => $resultado->status(), 'msg' => $resultado->json()]);
            return [];
        }

        $conteudo = $resultado->body();
        if (empty($conteudo)) {
            logs()->debug("Conteúdo obtido ao fazer a consulta está vazio.", ['status' => $resultado->status(), 'msg' => $resultado->json()]);
            return [];
        }

        $crawler = new Crawler($conteudo);
        
        $results = [];
        
        $crawler->filter('.col-lg-2')->each(function (Crawler $node) use (&$results) {
            if ($node->filter('.box_img_noticias')->count() > 0) {
               
                $name = $node->filter('h2')->last()->text();
                $link = $node->filter('a')->first()->attr('href');
                $date = $node->filter('.box_img_noticias h1')->first()->text();
                $month = $node->filter('.box_img_noticias h2')->first()->text();
                $category = $node->filter('a')->last()->text();

                $results[] = [
                    'name' => $name,
                    'date' => trim($date),
                    'month' => trim($month),
                    'link' => $link,
                    'category' => $category
                ];
                
            }
        });
    
        return $results;
    }
}
