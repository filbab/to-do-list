<?php

declare(strict_types=1);

namespace Domain\Task;

use Domain\Task\Queries\TaskQuery;
use Illuminate\Support\Collection;
use Domain\Task\Entities\Models\Task;
use Domain\Task\Commands\TaskCommand;
use App\Http\Requests\Task\ShowTasksRequest;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;

class TaskService
{
   private TaskQuery $task_query;
   private TaskCommand $task_command;

   public function __construct()
   {
      $this->task_query = new TaskQuery();
      $this->task_command = new TaskCommand();
   }

   public function getTasks(ShowTasksRequest $request): ?Collection
   {
      return $this->task_query->getTasks($request);
   }

   public function storeTask(CreateTaskRequest $request): Task
   {
      return $this->task_command->store($request);
      
   }

   public function updateTask(UpdateTaskRequest $request, Task $task): Task
   {
      return $this->task_command->update($request, $task);
   }

   public function destroyTask(Task $task): void
   {
      $this->task_command->destroy($task);
   }
}