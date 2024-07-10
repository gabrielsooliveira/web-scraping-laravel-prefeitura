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
        
        $resultados = [];
        $anterior = null;
        $proximo = null;

        $crawler->filter('.col-lg-2')->each(function (Crawler $node) use (&$resultados) {
            if ($node->filter('.box_img_noticias')->count() > 0) {

                $nome = $node->filter('h2')->last()->text();
                $link = $node->filter('a')->first()->attr('href');
                $dia = $node->filter('.box_img_noticias h1')->first()->text();
                $mes = $node->filter('.box_img_noticias h2')->first()->text();
                $categoria = $node->filter('a')->last()->text();

                $resultados['informes'][] = [
                    'nome' => $nome,
                    'dia' => trim($dia),
                    'mes' => trim($mes),
                    'link' => $link,
                    'categoria' => $categoria
                ];
            }
        });
      
        if ($crawler->filter('.previouspostslink')->count() > 0) {
            $previousHref = $crawler->filter('.previouspostslink')->attr('href');
            if (preg_match('/page\/(\d+)/', $previousHref, $matches)) {
                $anterior = (int)$matches[1];
            }
        }
        
        if ($crawler->filter('.nextpostslink')->count() > 0) {
            $nextHref = $crawler->filter('.nextpostslink')->attr('href');
            if (preg_match('/page\/(\d+)/', $nextHref, $matches)) {
                $proximo = (int)$matches[1];
            }
        }

        $resultados['paginacao'] = [
            'anterior' => $anterior,
            'atual' => $value,
            'proximo' => $proximo,
        ];

        return $resultados;
    }
}
