<?php

namespace App\Console\Commands;

use App\Models\Diarios_TCM;
use App\Services\TCM\DiarioScraperService;
use Illuminate\Console\Command;

class ProcessGetInfoDiarioTCM extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:getInfoDiarioTCM';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para coletar as menções a prefeitura de Salvador';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $diarios = Diarios_TCM::all();
        foreach ($diarios as $diario) {
            $valor = DiarioScraperService::getInfoDiario($diario["codigo"]);
            if ($valor == 1) {
                $diario->update([
                    'notificacao' => $valor
                ]);
            }
        }
    }
}
