<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Task\Commands\TaskCommand\Destroy;

use Domain\Task\Entities\Models\Task;

trait TaskCommandTrait
{
   private function createTask(array $data, ?array $user_ids=null): Task
   {
      $task = Task::create($data);

      if($user_ids) {
         $task->users()->sync($user_ids);
      }

      return $task;
   }
}