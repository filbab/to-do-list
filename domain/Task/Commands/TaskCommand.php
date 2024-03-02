<?php

declare(strict_types=1);

namespace Domain\Task\Commands;

use Domain\Task\Entities\Models\Task;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use Domain\Task\Queries\TaskStatusQuery;

class TaskCommand
{
   private Task $task;
   private TaskStatusQuery $task_status_query;

   public function __construct()
   {
      $this->task = new Task();
      $this->task_status_query = new TaskStatusQuery();
   }

   public function store(CreateTaskRequest $request): Task
   {
      $status = $this->task_status_query->findStatus($request->getStatus());

      $new_task = $this->task->create([
         'title' => $request->getTitle(),
         'description' => $request->getDescription(),
         'status_id' => $status->getId()
      ]);

      // Sync users
      UserTaskSynchronizer::syncUsers($new_task, $request->getUserIds());

      return $new_task;
   }

   public function update(UpdateTaskRequest $request, Task $task): Task
   {
      $status = $this->task_status_query->findStatus($request->getStatus());

      $task->update([
         'title' => $request->getTitle(),
         'description' => $request->getDescription(),
         'status_id' => $status->getId()
      ]);

      // Sync users
      UserTaskSynchronizer::syncUsers($task, $request->getUserIds());

      return $task;
   }

   public function destroy(Task $task): void
   {
      $task->delete();
   }
}