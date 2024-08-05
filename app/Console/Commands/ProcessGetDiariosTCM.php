<?php

namespace App\Console\Commands;

use App\Models\Diarios_TCM;
use Illuminate\Console\Command;
use App\Services\TCM\DiarioScraperService;
use Carbon\Carbon;

class ProcessGetDiariosTCM extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:getDiariosTCM';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Conseguindo coletar todos os diarios oficiais do TCM Bahia';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $diarios = DiarioScraperService::getAllDiario();

        foreach ($diarios["itens"] as $diario) {
            $data_publicacao = Carbon::createFromFormat('d/m/Y', $diario['data'])->format('Y-m-d');
            Diarios_TCM::create([
                'codigo' => $diario['numero'],
                'data_publicacao' => $data_publicacao,
                'diario_id' => $diario['id']
            ]);
            DiarioScraperService::getPdfDiario($diario);
        }
    }
}
