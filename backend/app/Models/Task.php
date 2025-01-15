<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'task';


    protected $fillable =
    [
        'title',
        'description',
        'category_id',
        'situacao_id',
        'user_id',
        'finished_at',
    ];

    //quando for atualizado ou feito um update sera pego a data de criacao e edicao     
    public $timestamps = true;

    public function situacao()
    {
        return $this->belongsTo(Situacao::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
