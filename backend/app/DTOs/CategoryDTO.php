<?php

namespace App\DTOs;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryDTO
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

    //model para listar
    public static function fromModel(Category $category): self
    {
        return new self(
            $category->id,
            $category->name,
            $category->created_at,
            $category->updated_at
        );
    }

    //model para criar/editar
    public static function makeFromRequest(CategoryRequest $request): self

    {
        return new self(
            $request->id,
            $request->name,
            $request->created_at,
            now()
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
