<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exoneracoes extends Model
{
    protected $table = 'exoneracoes';
    protected $fillable = [
        'nome',
        'data_exoneracao',
        'diario_id'
    ];
    
    public $timestamps = false;
    public function diarios(){
        return $this->belongsTo(Diarios::class);
    }
}
