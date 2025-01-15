<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    if (!User::where('email', 'exemplo@exemplo.com.br')->first()) {
      User::create([
        'name' => 'exemplo',
        'email' => 'exemplo@exemplo.com.br',
        'email_verified_at' => now(), // Define a data de verificação do e-mail como a data atual
        'password' => Hash::make('exemplo', ['rounds' => 12]),
        'genero_id' => 2,
        'situacao_id' => 1,
        'remember_token' => Str::random(10), // Cria um token aleatório de 10 caracteres
        'created_at' => now(),
        'updated_at' => now(),
      ]);
    }
  }
}
