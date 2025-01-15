<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Services\TaskServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskServices;

    public function __construct(TaskServices $taskServices)
    {
        $this->taskServices = $taskServices;
    }


    public function index()
    {
        return $this->taskServices->getTask();
    }

    public function show(Task $task): JsonResponse
    {
        return $this->taskServices->getTaskId($task);
    }

    public function store(TaskRequest $request): JsonResponse
    {
        return $this->taskServices->createTask($request);
    }

    public function update(Task $task, TaskRequest $request): JsonResponse
    {
        return $this->taskServices->updatedTask($task, $request);
    }
    public function destroy(Task $task): JsonResponse
    {
        return $this->taskServices->deletedTask($task);
    }
}
