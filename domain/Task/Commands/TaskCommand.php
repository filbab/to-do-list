<?php

declare(strict_types=1);

namespace Domain\Task\Commands;

use Domain\Task\Entities\Models\Task;
use App\Http\Requests\Task\CreateTaskRequest;

class TaskCommand
{
   private Task $task;

   public function __construct()
   {
      $this->task = new Task();
   }

   public function store(CreateTaskRequest $request): Task
   {
      $new_task = $this->task->create([
         'title' => $request->getTitle(),
         'description' => $request->getDescription(),
         'status' => $request->getStatus()
      ]);

      // Sync users
      UserTaskSynchronizer::syncUsers($new_task, $request->getUserIds());

      return $new_task;
   }
}