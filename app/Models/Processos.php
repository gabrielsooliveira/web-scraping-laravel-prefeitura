<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Processos extends Model
{
    protected $table = 'processos';
    protected $fillable = [
        'codigo',
        'descricao',
        'status'
    ];

    use HasFactory;

    public function diarios()
    {
        return $this->belongsToMany(Diarios_TCM::class, 'processos_diarios_tcm', 'processo_id', 'diario_tcm_id');
    }
}
