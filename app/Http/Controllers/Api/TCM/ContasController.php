<?php

namespace App\Http\Controllers\Api\TCM;

use App\Http\Controllers\Controller;
use App\Services\TCM\ContasScraperService;
use App\Services\TCM\DiarioScraperService;
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

        return view('pages.contas_descentralizada', compact('resultado'));
    }

    public function getParecerAll(){
        $resultados_um = ContasScraperService::Parecer();
        $resultados_dois = ContasScraperService::ParecerDescentralizada();

        if (empty($resultados_um) || empty($resultados_dois)) {
            return response()->json(['msg' => 'Não foi possível obter o parecer de contas.'], Response::HTTP_NOT_FOUND);
        }

        foreach ($resultados_um as $key => $value_um) {
            $resultado[$key] = array_merge($value_um, $resultados_dois[$key]);
        }

        return view('pages.contas', compact('resultado'));
    }

    public function getDiariosTCM(){
        $resultados = DiarioScraperService::getAllDiario();
        return view("pages.diario_tcm", compact('resultados'));
    }
}