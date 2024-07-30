<?php

declare (strict_types = 1);

namespace App\Services\DOM;

use App\Repositories\DOM\DiarioRepository;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Storage;
use App\Models\Diarios;

class DiarioScraperService
{
    public static function getAllDOMs(): array
    {
        $limstart = 0;
        $allDiarios = [];

        while (true) {
            $response = DiarioRepository::getDataDOMs($limstart);
            if ($response->failed()) {
                logs()->debug("Falha ao fazer a consulta ao repository.", ['status' => $response->status(), 'msg' => $response->json()]);
                break;
            }

            $html = $response->getBody()->getContents();
            $crawler = new Crawler($html);

            $diarios = $crawler->filter('.dmarticlesfilter_results_row')->each(function (Crawler $node) {
                $date = $node->filter('#dmarticlesfilter_results_date')->text();
                $title = trim(explode(' - ', $node->filter('a')->text())[1]);
                $codigo = preg_replace('/^DOM-/', '', $title);

                if (strpos($codigo, 'Republicado') !== false) {
                    $codigo = str_replace('-Republicado por erro de formatação.', '', $codigo);
                    $codigo = str_replace('-Republicado por erro de formataÃ§Ã£o.', '', $codigo);
                }

                $href = $node->filter('a')->attr('href');
                preg_match('/id=(\d+)/', $href, $matches);
                $id = $matches[1] ?? '0000';
                
                $pdfLink = self::getPdf($id, $codigo, $date);
                // $pdfInfo = self::getPdfInfo($pdfLink);

                return [
                    'data_publicacao' => $date,
                    'codigo' => trim($codigo),
                    'url' => $pdfLink
                ];
            });

            if (empty($diarios)) {
                break;
            }

            $allDiarios = array_merge($allDiarios, $diarios);
            $limstart += 10;
        }

        return $allDiarios;
    }

    public static function getRecentDOM(): array 
    {
        $ultimoRegistro = Diarios::orderBy('data_publicacao', 'desc')->orderBy('codigo', 'desc')->first();
        $dataUltimoRegistro = $ultimoRegistro ? $ultimoRegistro->data_publicacao : null;
        $codigoUltimoRegistro = $ultimoRegistro ? $ultimoRegistro->codigo : null;
        $resultado = DiarioRepository::getDataDOMs(0);
        if ($resultado->failed()) {
            logs()->debug("Falha ao fazer a consulta ao repository.", [
                'status' => $resultado->status(),
                'msg' => $resultado->json()
            ]);
            return [];
        }

        $html = $resultado->getBody()->getContents();
        $crawler = new Crawler($html);

        $diarios = $crawler->filter('.dmarticlesfilter_results_row')->each(function (Crawler $node) use ($dataUltimoRegistro, $codigoUltimoRegistro) {
            $date = $node->filter('#dmarticlesfilter_results_date')->text();
            $title = trim(explode(' - ', $node->filter('a')->text())[1]);
            $codigo = preg_replace('/^DOM-/', '', $title);
    
            if ($codigo > $codigoUltimoRegistro && $date > $dataUltimoRegistro) {
                if (strpos($codigo, 'Republicado') !== false) {
                    $codigo = str_replace(['-Republicado por erro de formatação.', '-Republicado por erro de formataÃ§Ã£o.'], '', $codigo);
                }

                $href = $node->filter('a')->attr('href');
                preg_match('/id=(\d+)/', $href, $matches);
                $id = $matches[1] ?? '0000';

                $pdfLink = self::getPdf($id, $codigo, $date);

                return [
                    'data_publicacao' => $date,
                    'codigo' => trim($codigo),
                    'url' => $pdfLink
                ];
            }

            return null;
        });

        $diarios = array_filter($diarios);
        return $diarios;
    }

    private static function getPdf(string $id, string $codigo, string $date): string
    {
        $resultado = DiarioRepository::getlinkPdf($id);
        $html = $resultado->getBody()->getContents();
        $crawler = new Crawler($html);
        $link = $crawler->filter('h3 a')->attr('href');
        $response = Http::get($link);
        $pdfContent = $response->body();

        // Extrair ano e mês da data
        $ano = date('Y', strtotime($date));
        $mes = date('m', strtotime($date));

        // Definir o caminho base
        $basePath = "public/DOM/{$ano}/{$mes}";
        $fileName = "dom-{$codigo}-{$date}.pdf";
        $filePath = "{$basePath}/{$fileName}";

        // Verificar se o arquivo já existe e adicionar "-republicado" se necessário
        $counter = 1;
        while (Storage::exists($filePath)) {
            $fileName = "dom-{$codigo}-{$date}-republicado";
            if ($counter > 1) {
                $fileName .= "-{$counter}";
            }
            $fileName .= ".pdf";
            $filePath = "{$basePath}/{$fileName}";
            $counter++;
        }

        // Criar diretório se não existir
        if (!Storage::exists($basePath)) {
            Storage::makeDirectory($basePath);
        }

        // Salvar o PDF no armazenamento
        Storage::put($filePath, $pdfContent);

        return $filePath;
    }


    private static function getPdfInfo(string $url): array
    {
        $response = Http::get($url);
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