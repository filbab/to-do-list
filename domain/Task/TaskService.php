<?php

declare(strict_types=1);

namespace Domain\Task;

use Domain\Task\Queries\TaskQuery;
use Illuminate\Support\Collection;
use Domain\Task\Entities\Models\Task;
use Domain\Task\Commands\TaskCommand;
use App\Http\Requests\Task\ShowTasksRequest;
use App\Http\Requests\Task\CreateTaskRequest;

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

   public function updateTask(ShowTasksRequest $request): Task
   {
      return $this->task_command->update($request);
   }

   public function removeTask(ShowTasksRequest $request): void
   {
      $this->task_command->remove($request);
   }
}