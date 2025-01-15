<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    use HasFactory;

    protected $table = 'genero';

    // Se você não quiser que o modelo use os timestamps, defina como false
    public $timestamps = true;

    // Defina quais campos podem ser preenchidos em massa
    protected $fillable = [
        'name'
    ];

}
