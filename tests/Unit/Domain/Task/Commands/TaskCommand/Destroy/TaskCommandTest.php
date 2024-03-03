<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Task\Commands\TaskCommand\Destroy;

use Tests\TestCase;
use App\Models\TaskStatus;
use Domain\Task\Commands\TaskCommand;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TaskCommandTest extends TestCase
{
   use DatabaseTransactions;
   use TaskCommandTrait;

   private TaskCommand $command;

   protected function setUp(): void
   {
      parent::setUp();

      $this->command = $this->app->make(TaskCommand::class);
   }

   /**
    * @feature Tasks
    * @scenario Destroy task
    * @case Existing task provided

    * @expectation Delete task from DB
    * @test
    */
    public function destroy_existingTaskProvided_deleteTaskFromDB(): void
    {
      // GIVEN
      $status = TaskStatus::factory()->create();

      $task = $this->createTask([
         'title' => "Initial title",
         'description' => "Initial description",
         'status_id' => $status->id
      ]);
 
      // WHEN
      $this->command->destroy($task);
       
       // THEN
      $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}