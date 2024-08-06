<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diarios extends Model
{
    protected $table = 'diarios_municipio';
    protected $fillable = [
        'codigo',
        'data_publicacao',
        'url'
    ];

    public function exoneracoes(){
        return $this->hasMany(Exoneracoes::class, 'diario_id', 'id');
    }
}
