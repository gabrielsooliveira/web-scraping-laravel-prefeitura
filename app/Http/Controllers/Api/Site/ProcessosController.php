<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Models\Processos;
use Illuminate\Http\Request;

class ProcessosController extends Controller
{
    public function index()
    {
        $processos = Processos::orderBy('created_at', 'desc')->paginate(10);
        return view("pages/lista_processos", compact("processos"));
    }

    public function store(Request $request)
    {
        Processos::create([
            "codigo" => $request["codigoP"],
            "status" => 1,
            "descricao" => $request["descricao"]
        ]);

        return redirect()->back();
    }

    public function show(int $id){
        $processo = Processos::where("id", $id)->first();

        return view("pages.editar_processo", compact("processo"));
    }

    public function update(Request $request, $id)
    {
        $processo = Processos::where("id", $id)->first();
        $processo->update($request->only(['descricao', 'status']));

        return redirect("lista-processos");
    }
}
