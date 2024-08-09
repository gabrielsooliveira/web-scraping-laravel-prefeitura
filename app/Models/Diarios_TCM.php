<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diarios_TCM extends Model
{
    protected $table = 'diarios_tcm';
    protected $fillable = [
        'codigo',
        'data_publicacao',
        'diario_id',
    ];

    use HasFactory;

    public function processos()
    {
        return $this->belongsToMany(Processos::class, 'processos_diarios_tcm', 'diario_tcm_id', 'processo_id');
    }
}
