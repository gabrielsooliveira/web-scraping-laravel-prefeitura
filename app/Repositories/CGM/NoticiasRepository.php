<?php

declare (strict_types = 1);

namespace App\Repositories\CGM;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class NoticiasRepository
{
    public static function getConteudoInformes($valor): Response
    {
        return Http::get("https://cgm.salvador.ba.gov.br/informe/page/$valor");
    }
}
