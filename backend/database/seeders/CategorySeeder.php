<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Category::where('name', 'Lazer')->first()) {
            Category::create([
                'id' => 1,
                'name' => 'Lazer',
            ]);
        }
        if (!Category::where('name', 'Viagem')->first()) {
            Category::create([
                'id' => 2,
                'name' => 'Viagem',
            ]);
        }
        if (!Category::where('name', 'Comida')->first()) {
            Category::create([
                'id' => 3,
                'name' => 'Comida',
            ]);
        }
        if (!Category::where('name', 'Comida')->first()) {
            Category::create([
                'id' => 4,
                'name' => 'Comida',
            ]);
        }
    }
}
