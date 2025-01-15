<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Codec\TimestampLastCombCodec;

class Situacao extends Model
{
    use HasFactory;


    //faz referencia a tabela situacao 
    protected $table = 'situacao';

    //quando for atualizado ou feito um update sera pego a data de criacao e edicao     
    public $timestamps = true;

    //campos da tabela
    protected $fillable = [
        'name', 
    ];

}
