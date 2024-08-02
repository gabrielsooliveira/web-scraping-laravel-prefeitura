<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CGM\NoticiasController;
use App\Http\Controllers\Api\PortalTransparencia\ServidoresController;
use App\Http\Controllers\Api\TCM\ContasController;
use App\Http\Controllers\Api\DOM\DiarioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.inicio');
})->name('home');

Route::get('/cgm/{value?}', [NoticiasController::class, 'getInformes'])->name('cgm_informes');
Route::get('/servidores', [ServidoresController::class, 'getServidores'])->name('portalt_servidores');
Route::get('/detalheservidor', [ServidoresController::class, 'getDetalheServidor'])->name('portalt_servidor_detalhes');
Route::get('/parecer/todos', [ContasController::class, 'getParecerAll'])->name('parecer_contas_todos');
Route::get('/parecer/prefeitura', [ContasController::class, 'getParecer'])->name('parecer_contas_prefeitura');
Route::get('/parecer/descentralizada', [ContasController::class, 'getParecerDesc'])->name('parecer_contas_descentralizada');
Route::get('/diario', [DiarioController::class, 'getDiariosAll'])->name('diario_oficial');

Route::get('/diario/tcm', [ContasController::class, 'getDiariosTCM'])->name('diario_teste_tcm');