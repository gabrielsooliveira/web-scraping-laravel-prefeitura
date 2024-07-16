<?php

namespace App\Http\Controllers\Api\TCM;

use App\Http\Controllers\Controller;
use App\Services\TCM\ContasScraperService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class ContasController extends Controller
{
    public function getParecer(){
        $resultado = ContasScraperService::Parecer();
        if (empty($resultado)) {
            return response()->json(['msg' => 'Não foi possível obter o parecer de contas.'], Response::HTTP_NOT_FOUND);
        }

        return view('pages.contas_prefeitura', compact('resultado'));
    }

    
    public function getParecerDesc(){
        $resultado = ContasScraperService::ParecerDescentralizada();
        if (empty($resultado)) {
            return response()->json(['msg' => 'Não foi possível obter o parecer de contas.'], Response::HTTP_NOT_FOUND);
        }

        return view('pages.contas_prefeitura', compact('resultado'));
    }

    public function getParecerAll(){
        $resultado_um = ContasScraperService::Parecer();
        $resultado_dois = ContasScraperService::ParecerDescentralizada();

            $resultado = Arr::crossJoin($resultado_um, $resultado_dois);
            dd($resultado);
        
    }
}