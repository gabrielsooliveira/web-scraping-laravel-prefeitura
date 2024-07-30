<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diarios extends Model
{
    protected $table = 'diarios';
    protected $fillable = [
        'codigo',
        'data_publicacao',
        'url'
    ];

    public $timestamps = false;
}
