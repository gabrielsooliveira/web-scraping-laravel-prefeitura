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
        'diario_id'
    ];

    public $timestamps = false;
}
