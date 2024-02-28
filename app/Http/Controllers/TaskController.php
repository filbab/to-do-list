<?php

namespace App\Http\Controllers;

use Domain\Task\TaskService;
use App\Http\Requests\Task\ShowTasksRequest;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Resources\Task as ResourcesTask;

class TaskController extends Controller
{
    public function index(ShowTasksRequest $request, TaskService $task_service)
    {
        $tasks = $task_service->getTasks($request);

        return ResourcesTask::collection($tasks);
    }

    public function store(CreateTaskRequest $request, TaskService $task_service)
    {
        $task = $task_service->storeTask($request);

        return ResourcesTask::make($task);
    }

    public function update(ShowTasksRequest $request, TaskService $task_service)
    {
        $task = $task_service->updateTask($request);

        return ResourcesTask::make($task);
    }

    public function destroy(ShowTasksRequest $request, TaskService $task_service)
    {
        $task_service->removeTask($request);

        return response()->json([], 204);
    }
}
