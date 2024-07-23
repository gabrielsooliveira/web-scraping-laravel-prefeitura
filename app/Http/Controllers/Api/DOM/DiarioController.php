<?php

namespace App\Http\Controllers\API\DOM;

use App\Http\Controllers\Controller;
use App\Services\DOM\DiarioScraperService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class DiarioController extends Controller
{
    public function getDiariosAll(int $value = 0){
        $resultado = DiarioScraperService::Diario($value);
        if (empty($resultado)) {
            return response()->json(['msg' => 'Não foi possível obter a os diarios oficiais do Municipio.'], Response::HTTP_NOT_FOUND);
        }

        return view('pages.diario', compact('resultado'));
    }
}
