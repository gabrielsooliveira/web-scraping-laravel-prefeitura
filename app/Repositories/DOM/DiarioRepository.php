<?php

declare (strict_types = 1);

namespace App\Repositories\DOM;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class DiarioRepository
{
    public static function getPdfs(int $limstart): Response
    {   $today = now()->format('Y-m-d');
        return Http::get("http://www.dom.salvador.ba.gov.br/index.php?filterDateFrom=2001-01-01&filterDateTo=$today&option=com_dmarticlesfilter&view=articles&Itemid=3&userSearch=1&limstart=0&limitstart=$limstart");
    }

    public static function getlinkPdf(string $id): Response
    {   
        return Http::get("http://www.dom.salvador.ba.gov.br/index.php?option=com_content&view=article&id=$id");
    }
}

