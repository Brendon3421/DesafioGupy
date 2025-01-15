<?php

namespace App\Services;

use App\DTOs\TaskDTO;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Exception;
use Illuminate\Support\Facades\DB;


class TaskServices
{


    public function getTask()
    {
        try {
            $userId = auth()->id();
            $task = Task::with(['situacao', 'user'])->where('user_id', $userId)->orderBy("ID", "DESC")->paginate(40);

            $taskData = $task->map(function ($task) {
                return TaskDTO::fromModel($task)->toArray();
            });

            return response()->json([
                'status' => true,
                'task' => $taskData,
                'message' => 'task listadas com sucesso!',
                'pagination' => [
                    'total' => $task->total(),
                    'count' => $task->count(),
                    'per_page' => $task->perPage(),
                    'current_page' => $task->currentPage(),
                    'total_pages' => $task->lastPage()
                ],
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Nao foi possivel listar todas as task!",
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function getTaskId(Task $task)
    {
        try {
            $task->load(['situacao', 'user']);
            $taskDTO = TaskDTO::fromModel($task);

            return response()->json([
                'status' => true,
                'task' => $taskDTO->toArray(),
                'message' => 'task encontrada com sucesso!',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Nao foi possivel listar todas a task!",
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function createTask(TaskRequest $request)
    {
        try {
            DB::beginTransaction();
            // Obtém o ID do usuário autenticado
            $userId = auth()->id();
            // Cria o DTO a partir do request e adiciona o user_id
            $taskDTO = TaskDTO::makeFromRequest($request);
            $taskDTO->user_id = $userId;
            // Cria a tarefa no banco de dados
            $task = Task::create($taskDTO->toArray());
            DB::commit();

            return response()->json([
                'status' => true,
                'task' => $task->toArray(),
                'message' => 'Task criada com sucesso!',
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Erro ao cadastrar task',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updatedTask(Task $task, TaskRequest $request)
    {
        try {
            DB::beginTransaction();
            // Obtém o ID do usuário autenticado
            $userId = auth()->id();
            // Cria o DTO a partir do request e adiciona o user_id
            $taskDTO = TaskDTO::makeFromRequest($request);
            $taskDTO->user_id = $userId;
            // Atualiza a tarefa no banco de dados
            $task->update($taskDTO->toArray());
            DB::commit();
            return response()->json([
                'status' => true,
                'task' => $task->toArray(),
                'message' => 'Task atualizada com sucesso!',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => true,
                'error' => $e->getMessage(),
                'message' => 'Falha ao atualizar Task',
            ], 400);
        }
    }

    public function deletedTask(Task $task)
    {
        DB::beginTransaction();
        try {
            // Apagar o usuário do banco de dados
            $task->delete();
            // Confirmar a transação
            DB::commit();
            // Retorna se apagou com sucesso
            return response()->json([
                'status' => true,
                'message' => "Task excluído com sucesso"
            ], 200);
        } catch (Exception $e) {
            // Reverter a transação em caso de erro
            DB::rollBack();
            // Retorna a mensagem de erro
            return response()->json([
                'status' => false,
                'message' => "Ocorreu um erro durante o processo de exclusão",
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
