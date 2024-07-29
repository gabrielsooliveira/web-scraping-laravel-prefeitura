<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DOM\DiarioScraperService;
use App\Models\Diarios;

class ProcessGetAllDOMs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:getAllDOMs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processo que captura todos os diarios oficiais existentes no site da prefeitura e grava no banco de dados todas as informações necessarias';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $diarios = DiarioScraperService::getAllDOMs();

        foreach ($diarios as $item) {
            Diarios::create([
                'codigo' => $item['codigo'],
                'data_publicacao' => $item['data_publicacao'],
            ]);
        }
    }
}
