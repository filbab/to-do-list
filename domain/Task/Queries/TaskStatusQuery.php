<?php

declare(strict_types=1);

namespace Domain\Task\Queries;

use Domain\Task\Entities\Models\TaskStatus;

class TaskStatusQuery
{
   private TaskStatus $task_status;

   public function __construct()
   {
      $this->task_status = new TaskStatus();
   }

   public function findStatus(string $name): TaskStatus
   {
      return $this->task_status->where('name', $name)->first();
   }
}