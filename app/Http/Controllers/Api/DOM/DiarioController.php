<?php

namespace App\Http\Controllers\API\DOM;

use App\Http\Controllers\Controller;
use App\Models\Diarios;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class DiarioController extends Controller
{
    public function getDiariosAll(){
        $resultados = Diarios::orderBy('data_publicacao', 'desc')->paginate(10);
        return view('pages.diario', compact('resultados'));
    }
}
