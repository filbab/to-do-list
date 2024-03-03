<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Task\Commands\TaskCommand\Update;

use Mockery;
use Domain\Task\Entities\Models\Task;
use App\Http\Requests\Interfaces\ICreateUpdateTaskRequest;

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

   private function mockRequest(
      string $title = "Title",
      ?string $description = "Description",
      string $status = "Status",
      array $user_ids = []
   ): ICreateUpdateTaskRequest
   {
     $mock = Mockery::mock(ICreateUpdateTaskRequest::class);

     $mock->allows([
      'getTitle' => $title,
      'getDescription' => $description,
      'getStatus' => $status,
      'getUserIds' => $user_ids
     ]);

     return $mock;
   }
}