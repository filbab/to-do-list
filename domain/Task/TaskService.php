<?php

declare(strict_types=1);

namespace Domain\Task;

use Domain\Task\Queries\TaskQuery;
use Illuminate\Support\Collection;
use Domain\Task\Entities\Models\Task;
use Domain\Task\Commands\TaskCommand;
use App\Http\Requests\Interfaces\IShowTasksRequest;
use App\Http\Requests\Interfaces\ICreateUpdateTaskRequest;

class TaskService
{
   private TaskQuery $task_query;
   private TaskCommand $task_command;

   public function __construct()
   {
      $this->task_query = new TaskQuery();
      $this->task_command = new TaskCommand();
   }

   public function getTasks(IShowTasksRequest $request): ?Collection
   {
      return $this->task_query->getTasks($request);
   }

   public function storeTask(ICreateUpdateTaskRequest $request): Task
   {
      return $this->task_command->store($request);
      
   }

   public function updateTask(ICreateUpdateTaskRequest $request, Task $task): Task
   {
      return $this->task_command->update($request, $task);
   }

   public function destroyTask(Task $task): void
   {
      $this->task_command->destroy($task);
   }
}