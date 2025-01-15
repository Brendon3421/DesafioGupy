<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // chama a seeder dos user para utilizar como exemplo
        $this->call([
            SituacaoSeeder::class,
            GeneroSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
        ]);
    }
}
