<?php

declare (strict_types = 1);

namespace App\Services\DOM;

use App\Repositories\DOM\DiarioRepository;
use Carbon\Carbon;
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

            if ($codigo > $codigoUltimoRegistro && $date >= $dataUltimoRegistro) {
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
        $ano = date('Y', strtotime($date));
        $mes = date('m', strtotime($date));
        $basePath = "{$ano}/{$mes}";
        $fileName = "dom-{$codigo}-{$date}.pdf";
        $url = "{$basePath}/{$fileName}";
        $filePath = "public/DOM/{$url}";
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

        if (!Storage::exists($basePath)) {
            Storage::makeDirectory($basePath);
        }

        Storage::put($filePath, $pdfContent);

        return $url;
    }


    public static function getPdfInfo(string $url): array
    {
        ini_set('memory_limit', '3G');

        $filePath = Storage::get("public/DOM/$url");
        $parser = new Parser();
        $pdf = $parser->parseContent($filePath);
        $text = $pdf->getText();

        preg_match_all('/(?:exonera[^\n]*\n(?:[^\n]*\n?){0,1}[^\n]*(?:\n|$)){1,2}/is', $text, $matches);

        $dataNames = [];
        $filtros = [
            "/(?:nomear\s+a\s+servidora\s+abaixo\s+relacionada.*?exerce\s+o\s+cargo\s+em\s+comissão\s+de\s+Diretor.*?Unidade\s+de\s+Ensino:\s*([^0-9]+)\s*(?:\d{2} de \w+ de \d{4}))/is",
            "/SERVIDOR\s+MATRICULA\s+CÓDIGO\/ESCOLA\s*NÍVEL\s*([\s\S]*?)\s*GABINETE\s*DA\s*SECRETARIA\s*MUNICIPAL\s*DA\s*EDUCAÇÃO\s*,\s*(\d{2} de \w+ de \d{4})/i",
            "/desde \d{2}\/\d{2}\/\d{4},\s*([^\n,]+?)(?:,|$)/u",
            "/a partir de (\d{2}\/\d{2}\/\d{4})[^\n]*o servidor\s*([^\n,]+),/",
            "/desde (\d{2}\/\d{2}\/\d{4})[^\n]*a servidora\s*([\s\S]*?)(?:,\s*|$)/i",
            "/desde (\d{2}\/\d{2}\/\d{4})[^\n]*o servidor\s*([\s\S]*?)(?:,\s*|$)/i",
        ];

        foreach ($filtros as $filtro) {
            preg_match_all($filtro, $text, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                $date = isset($match[1]) ? trim($match[1]) : null;
                $name = isset($match[2]) ? trim(preg_replace('/\s+/', ' ', $match[2])) : null;

                if ($date) {
                    try {
                        $date = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
                    } catch (\Exception $e) {
                        dd("Erro ao transformar a data: $date e o pdf que ocorreu o erro foi o $url", $e->getMessage());
                    }
                }

                $dataNames[] = [
                    'data_exoneracao' => $date,
                    'nome' => $name,
                ];
            }
        }

        return $dataNames;
    }
}
