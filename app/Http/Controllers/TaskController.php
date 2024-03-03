<?php

namespace App\Http\Controllers;

use Domain\Task\TaskService;
use Domain\Task\Entities\Models\Task;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\QueryParam;
use App\Http\Resources\Task as TaskResource;
use App\Http\Requests\Task\ShowTasksRequest;
use Knuckles\Scribe\Attributes\ResponseFromFile;
use App\Http\Requests\Task\CreateUpdateTaskRequest;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $service
    ) {}

    /**
     * @bodyParam [] []
     */
    #[QueryParam("title")]
    #[QueryParam("status")]
    #[QueryParam("user_ids[]", type:"integer", example:"12")]
    #[ResponseFromFile("docs/api_responses/index_200.json", 200)]
    #[ResponseFromFile("docs/api_responses/401.json", 401)]
    public function index(ShowTasksRequest $request)
    {
        $tasks = $this->service->getTasks($request);

        return TaskResource::collection($tasks);
    }

    #[BodyParam("title")]
    #[BodyParam("description", type:"string (nullable)")]
    #[BodyParam("status", enum:["pending", "in", "completed"])]
    #[BodyParam("user_ids", type:"array of integers", example:[12, 34, 56])]
    #[ResponseFromFile("docs/api_responses/store_201.json", 201)]
    #[ResponseFromFile("docs/api_responses/store_422.json", 422)]
    #[ResponseFromFile("docs/api_responses/401.json", 401)]
    public function store(CreateUpdateTaskRequest $request)
    {
        $task = $this->service->storeTask($request);

        return TaskResource::make($task);
    }

    #[BodyParam("title")]
    #[BodyParam("description", type:"string (nullable)")]
    #[BodyParam("status", enum:["pending", "in", "completed"])]
    #[BodyParam("user_ids", type:"array of integers", example:[12, 34, 56])]
    #[ResponseFromFile("docs/api_responses/update_200.json", 200)]
    #[ResponseFromFile("docs/api_responses/update_404.json", 404)]
    #[ResponseFromFile("docs/api_responses/update_422.json", 422)]
    #[ResponseFromFile("docs/api_responses/401.json", 401)]
    public function update(CreateUpdateTaskRequest $request, Task $task)
    {
        $task = $this->service->updateTask($request, $task);

        return TaskResource::make($task);
    }

    #[ResponseFromFile("docs/api_responses/destroy_204.json", 204)]
    #[ResponseFromFile("docs/api_responses/destroy_404.json", 404)]
    #[ResponseFromFile("docs/api_responses/401.json", 401)]
    public function destroy(Task $task)
    {
        $this->service->destroyTask($task);

        return response()->json([], 204);
    }
}
