<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Diarios;
use App\Services\DOM\DiarioScraperService;

class ProcessDailyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:getRecentDOM';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Esse comando faz o processamento do DOM mais recente e grava no banco de dados os dados necessarios';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $diarios = DiarioScraperService::getRecentDOM();
        // o foreach foi colocado na intenção de caso houver mais de um registro encontrado subir todos os registros encontrados
        foreach ($diarios as $item) {
            Diarios::create([
                'codigo' => $item['codigo'],
                'data_publicacao' => $item['data_publicacao']
            ]);
        }
    }
}
