<?php

namespace App\Http\Controllers\Api\CGM;

use App\Http\Controllers\Controller;
use App\Services\CGM\NoticiasScraperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class NoticiasController extends Controller
{
    public function getInformes()
    {
        $resultado = NoticiasScraperService::Informes();
        if (empty($resultado)) {
            return response()->json(['msg' => 'Não foi possível obter a tabela de classificação do brasileirão série A.'], Response::HTTP_NOT_FOUND);
        }

        return view('noticias', compact('resultado'));
    }
}
