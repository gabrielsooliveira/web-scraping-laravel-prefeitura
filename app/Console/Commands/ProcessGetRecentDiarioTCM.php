<?php

namespace App\Console\Commands;

use App\Models\Diarios_TCM;
use App\Services\TCM\DiarioScraperService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProcessGetRecentDiarioTCM extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:getRecentDiarioTCM';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $diarios = DiarioScraperService::getRecentDiario();

        foreach ($diarios as $diario) {
            $data_publicacao = Carbon::createFromFormat('d/m/Y', $diario['data'])->format('Y-m-d');
            Diarios_TCM::create([
                'codigo' => $diario['numero'],
                'data_publicacao' => $data_publicacao,
                'diario_id' => $diario['id']
            ]);
            DiarioScraperService::getPdfDiario($diario);
            DiarioScraperService::getInfoDiario($diario['numero']);
        }
    }
}
