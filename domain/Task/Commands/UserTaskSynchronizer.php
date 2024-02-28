<?php

declare(strict_types=1);

namespace Domain\Task\Commands;

use Domain\Task\Entities\Models\Task;

class UserTaskSynchronizer
{
   public static function syncUsers(Task $task, array $user_ids): void
   {
      $task->users()->sync($user_ids);
   }  
}