<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CGM\NoticiasController;
use App\Http\Controllers\Api\PortalTransparencia\ServidoresController;
use App\Http\Controllers\Api\TCM\ContasController;
use App\Http\Controllers\Api\DOM\DiarioController;
use App\Http\Controllers\Api\Site\ProcessosController;

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
    return view("pages.inicio");
})->name('home');

Route::get('/lista-processos', [ProcessosController::class, 'index'])->name('index_processos');
Route::post('/processo', [ProcessosController::class, 'store'])->name('store_processos');
Route::get('/processo/{id}', [ProcessosController::class, 'show'])->name('show_processos');
Route::put('/resource/{id}', [ProcessosController::class, 'update'])->name("update_processos");
#Noticias
Route::get('/cgm/{value?}', [NoticiasController::class, 'getInformes'])->name('cgm_informes');
#Servidores
Route::get('/servidores', [ServidoresController::class, 'getServidores'])->name('portalt_servidores');
Route::get('/detalheservidor', [ServidoresController::class, 'getDetalheServidor'])->name('portalt_servidor_detalhes');
#Contas
Route::get('/parecer/todos', [ContasController::class, 'getParecerAll'])->name('parecer_contas_todos');
Route::get('/parecer/prefeitura', [ContasController::class, 'getParecer'])->name('parecer_contas_prefeitura');
Route::get('/parecer/descentralizada', [ContasController::class, 'getParecerDesc'])->name('parecer_contas_descentralizada');
Route::get('/diario/tcm', [ContasController::class, 'getDiariosTCM'])->name('diario_teste_tcm');
#Diario
Route::get('/diario', [DiarioController::class, 'getDiariosAll'])->name('diario_oficial');

