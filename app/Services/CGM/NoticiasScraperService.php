<?php

declare (strict_types = 1);

namespace App\Services\CGM;

use App\Repositories\CGM\NoticiasRepository;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;

class NoticiasScraperService
{
    public static function Informes(): array
    {
        $valor = 1;
        $resultado = NoticiasRepository::getConteudoInformes($valor);
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

        // Array para armazenar os resultados
        $results = [];
        
        $crawler->filter('.col-lg-2')->each(function (Crawler $node) use (&$results) {
            // Filtra apenas os elementos que contêm a classe 'box_img_noticias'
            if ($node->filter('.box_img_noticias')->count() > 0) {
                // Obtém o link do primeiro elemento <a> dentro de .col-lg-2
                $link = $node->filter('a')->first()->attr('href');
                
                // Obtém o texto de h1 e h2 dentro de .box_img_noticias
                $date = $node->filter('.box_img_noticias h1')->first()->text();
                $month = $node->filter('.box_img_noticias h2')->first()->text();
                
                $results[] = [
                    'date' => trim($date),
                    'month' => trim($month),
                    'link' => $link,
                ];
            }
        });
        
        return $results;
    }
}
