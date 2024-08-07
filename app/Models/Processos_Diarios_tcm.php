<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Processos_Diarios_tcm extends Model
{
    protected $table = 'processos_diarios_tcm';
    protected $fillable = [
        'diario_tcm_id',
        'processo_id',
    ];

    public $timestamps = false;

    use HasFactory;

    public function diario()
    {
        return $this->belongsTo(Diarios_TCM::class, 'diario_tcm_id');
    }

    public function processo()
    {
        return $this->belongsTo(Processos::class, 'processo_id');
    }
}
