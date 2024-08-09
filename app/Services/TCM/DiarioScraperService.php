<?php

declare (strict_types = 1);

namespace App\Services\TCM;

use App\Models\Diarios_TCM;
use App\Models\Processos;
use App\Repositories\TCM\ContasRepository;
use DateTime;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Storage;

class DiarioScraperService
{
    public static function getAllDiario(): array
    {
        $links = ContasRepository::getDiario();
        return $links->json();
    }

    public static function getRecentDiario(): array
    {
        $ultimo_diario = Diarios_TCM::orderBy("data_publicacao", "desc")->first();
        $diarios = ContasRepository::getDiario();
        $diarios_a = $diarios->json();
        $diarios_recentes = [];

        $diarios_recentes = [];

        foreach ($diarios_a["itens"] as $diario) {
            if ($diario["numero"] <= $ultimo_diario->codigo) {
                continue;
            }

            $diarios_recentes[] = $diario;
        }

        return $diarios_recentes;
    }

    public static function getPdfDiario(array $diario): void
    {
        $url = "https://egbanet.egba.ba.gov.br/tcm/portal/edicoes/download/" . $diario['id'];
        $pdfContent = file_get_contents($url);
        $fileName = 'Diario_TCM/edicao_' . $diario['numero'] . '.pdf';
        Storage::disk('public')->put($fileName, $pdfContent);
    }

    public static function getInfoDiario(int $value) : array
    {
        $fileContent = Storage::get("public/Diario_TCM/edicao_$value.pdf");
        $parser = new Parser();
        $pdf = $parser->parseContent($fileContent);
        $text = $pdf->getText();

        $procesos = Processos::where('status', 1)->get();

        $processos_mencionados = [];

        foreach ($procesos as $processo) {
            if (stripos($text, $processo["codigo"]) !== false) {
                $processos_mencionados[] = $processo;
            }
        }

        return $processos_mencionados;
    }
}
