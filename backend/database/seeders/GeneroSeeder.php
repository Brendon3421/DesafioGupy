<?php

namespace Database\Seeders;

use App\Models\Genero;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Genero::where('name', 'masculino')->first()) {
            Genero::create([
                'id' => 1,
                'name' => 'masculino'
            ]);
        } if(!Genero::where('name', 'femino')->first()){
            Genero::create([
                'id'=> 2,
                'name' => 'feminino'
            ]);
        } if(!Genero::where('name', 'outros')->first()){
            Genero::create([
                'id'=> 3,
                'name' => 'outros'
            ]);
        }
    }
}
