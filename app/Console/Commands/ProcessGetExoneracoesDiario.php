<?php

namespace App\Console\Commands;

use App\Models\Exoneracoes;
use Illuminate\Console\Command;
use App\Models\Diarios;
use App\Services\DOM\DiarioScraperService;

class ProcessGetExoneracoesDiario extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:getExoneracoesDiario';

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
        $diarios = Diarios::all();

        foreach ($diarios as $value) {
            $exoneracoes = DiarioScraperService::getPdfInfo($value['url']);
            foreach ($exoneracoes as $item) {
                Exoneracoes::create([
                    'nome' => $item['nome'],
                    'data_exoneracao' => $item['data_exoneracao'],
                    'diario_id' => $value['id']
                ]);
            }
        }
    }
}
