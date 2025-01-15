<?php

namespace Database\Seeders;

use App\Models\Situacao;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SituacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!Situacao::where('name', 'ativo')->first()){
            Situacao::create([
                'id' => 1,
                'name' => 'Ativo',
            ]);
        }
        if(!Situacao::where('name', 'Inativo')->first()){
            Situacao::create([
                'id' => 2,
                'name' => 'Finalizado',
            ]);
        }
        if(!Situacao::where('name', 'Excluido')->first()){
            Situacao::create([
                'id' => 3,
                'name' => 'Excluido',
            ]);
        }
    }
}
