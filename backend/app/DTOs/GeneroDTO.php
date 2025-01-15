<?php

namespace App\DTOs;

use App\Models\Genero;

class GeneroDTO
{
    public $id;
    public $name;
    public $created_at;
    public $updated_at;

    public function __construct($id, $name, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function fromModel(Genero $genero): self
    {
        return new self (
            $genero->id,
            $genero->name,
            $genero->created_at,
            $genero->updated_at
        );
    }

    public static function fromCollection($generos)
    {
        return $generos->map(function ($genero) {
            return self::fromModel($genero);
        });
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
