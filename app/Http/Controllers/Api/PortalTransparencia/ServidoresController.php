<?php

namespace App\Http\Controllers\Api\PortalTransparencia;

use App\Http\Controllers\Controller;
use App\Services\PortalTransparencia\ServidoresScraperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


class ServidoresController extends Controller
{
    public function getServidores()
    {
        $resultado = ServidoresScraperService::Servidores();
        if (empty($resultado)) {
            return response()->json(['msg' => 'Não foi possível obter a as noticias da CGM.'], Response::HTTP_NOT_FOUND);
        }

        return view('noticias', compact('resultado'));
    }
}
