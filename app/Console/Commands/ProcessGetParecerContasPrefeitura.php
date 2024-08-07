<?php

namespace App\Console\Commands;

use App\Models\Processos;
use App\Services\TCM\ContasScraperService;
use Illuminate\Console\Command;

class ProcessGetParecerContasPrefeitura extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:getParecerContasPrefeitura';

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
        $resultados = ContasScraperService::Parecer();

        foreach ($resultados as $anoconta) {
            Processos::create([
                "codigo" => $anoconta["PREFEITURA"]["processo"],
                "status" => 0
            ]);
        }
    }
}
