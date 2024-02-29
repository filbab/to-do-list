<?php

namespace App\Http\Controllers;

use Domain\Task\TaskService;
use Domain\Task\Entities\Models\Task;
use App\Http\Resources\Task as TaskResource;
use App\Http\Requests\Task\ShowTasksRequest;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $service
    ) {}

    public function index(ShowTasksRequest $request)
    {
        $tasks = $this->service->getTasks($request);

        return TaskResource::collection($tasks);
    }


    public function store(CreateTaskRequest $request)
    {
        $task = $this->service->storeTask($request);

        return TaskResource::make($task);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task = $this->service->updateTask($request, $task);

        return TaskResource::make($task);
    }

    public function destroy(Task $task)
    {
        $this->service->destroyTask($task);

        return response()->json([], 204);
    }
}
