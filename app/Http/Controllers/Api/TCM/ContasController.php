<?php

namespace App\Http\Controllers\Api\TCM;

use App\Http\Controllers\Controller;
use App\Services\TCM\ContasScraperService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContasController extends Controller
{
    public function getParecer(){
        $resultado = ContasScraperService::Parecer();
        if (empty($resultado)) {
            return response()->json(['msg' => 'Não foi possível obter o parecer de contas.'], Response::HTTP_NOT_FOUND);
        }

        return view('pages.contas', compact('resultado'));
    }
}