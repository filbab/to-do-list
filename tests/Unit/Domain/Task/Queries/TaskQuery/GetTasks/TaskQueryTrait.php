<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Task\Queries\TaskQuery\GetTasks;

use Mockery;
use App\Models\Task;
use App\Http\Requests\Interfaces\IShowTasksRequest;

trait TaskQueryTrait
{
   private function createTask(array $data, ?array $user_ids=null): Task
   {
      $task = Task::factory()->create($data);

      if($user_ids) {
         $task->users()->sync($user_ids);
      }

      return $task;
   }

   private function mockRequest(
      ?string $title = null,
      ?string $status = null,
      ?array $user_ids = null
   ): IShowTasksRequest
   {
     $mock = Mockery::mock(IShowTasksRequest::class);

     $mock->allows([
      'getTitle' => $title,
      'getStatus' => $status,
      'getUserIds' => $user_ids
     ]);

     return $mock;
   }
}