<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Task\Commands\TaskCommand\Store;

use Mockery;
use App\Http\Requests\Interfaces\ICreateUpdateTaskRequest;

trait TaskCommandTrait
{
   private function mockRequest(
      string $title = null,
      ?string $description = null,
      string $status = null,
      array $user_ids = null
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