<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category'; // Nome da tabela no banco de dados

    public $timestamps = true; // Indica que a tabela tem campos created_at e updated_at

    protected $fillable = ['name']; // Campos que podem ser preenchidos
}
