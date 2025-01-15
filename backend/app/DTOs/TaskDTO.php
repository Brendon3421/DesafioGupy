<?php

namespace App\DTOs;

use App\Http\Requests\TaskRequest;
use App\Models\Task;

class TaskDTO
{
    public $id;
    public $title;         // Correção de 'name' para 'title' conforme o seu modelo
    public $description;
    public $created_at;
    public $updated_at;
    public $finished_at;
    public $category_id;
    public $situacao_id;
    public $user_id;

    // Construtor ajustado para adicionar todas as propriedades
    public function __construct($id, $title, $description, $created_at, $updated_at, $finished_at, $category_id, $situacao_id, $user_id)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->finished_at = $finished_at;
        $this->category_id = $category_id;
        $this->situacao_id = $situacao_id;
        $this->user_id = $user_id;
    }

    // Model para listar
    public static function fromModel(Task $task): self
    {
        return new self(
            $task->id,
            $task->title,
            $task->description,
            $task->created_at,
            $task->updated_at,
            $task->finished_at,
            $task->category->id,
            $task->situacao->id,
            $task->user_id
        );
    }

    // Model para criar/editar
    public static function makeFromRequest(TaskRequest $request): self
    {
        return new self(
            $request->id,
            $request->title,
            $request->description,
            now(),
            $request->updated_at,
            $request->finished_at,
            $request->category_id,
            $request->situacao_id ?? 1,
            $request->user_id
        );
    }

    // Método para converter o DTO para um array
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'finished_at' => $this->finished_at,
            'category_id' => $this->category_id,
            'situacao_id' => $this->situacao_id,
            'user_id' => $this->user_id
        ];
    }
}
