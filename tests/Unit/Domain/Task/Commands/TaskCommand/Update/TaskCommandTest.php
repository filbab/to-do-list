<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Task\Commands\TaskCommand\Update;

use App\Models\TaskStatus;
use App\Models\User;
use Domain\Task\Commands\TaskCommand;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

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
    * @scenario Update task
    * @case Valid data provided with one user, initially two assigned

    * @expectation Return updated task with one user
    * @test
    */
    public function update_validDataProvidedWithOneUser_returnUpdatedTaskWithOneUser(): void
    {
      // GIVEN
      $user_1 = User::factory()->create();
      $user_2 = User::factory()->create();

      $status = TaskStatus::factory()->create();

      $task = $this->createTask([
         'title' => "Initial title",
         'description' => "Initial description",
         'status_id' => $status->id
      ], [$user_1->id, $user_2->id]);

      $request = $this->mockRequest(
         title: "Updated title",
         description: null,
         status: $status->name,
         user_ids: [$user_1->id]
      );
 
      // WHEN
      $result = $this->command->update($request, $task);
       
       // THEN
      $this->assertEquals("Updated title", $result->title);
      $this->assertEquals("", $result->description);
      $this->assertEquals($status->name, $result->status->name);
      $this->assertCount(1, $result->users);
      $this->assertEquals($user_1->name, $result->users->first()->name);
    }

    /**
    * @feature Tasks
    * @scenario Update task
    * @case Valid data provided with two users, initially none assigned

    * @expectation Return updated task with two users
    * @test
    */
    public function update_validDataProvidedWithMultipleUser_returnUpdatedTaskWithTwoUsers(): void
    {
      // GIVEN
      $user_1 = User::factory()->create();
      $user_2 = User::factory()->create();

      $status = TaskStatus::factory()->create();

      $task = $this->createTask([
         'title' => "Initial title",
         'description' => "Initial description",
         'status_id' => $status->id
      ]);

      $request = $this->mockRequest(
         title: "Initial title",
         description: "Initial description",
         status: $status->name,
         user_ids: [$user_1->id, $user_2->id]
      );
 
      // WHEN
      $result = $this->command->update($request, $task);
       
       // THEN
      $this->assertEquals("Initial title", $result->title);
      $this->assertEquals("Initial description", $result->description);
      $this->assertEquals($status->name, $result->status->name);
      $this->assertCount(2, $result->users);
      $this->assertEquals($user_1->name, $result->users[0]->name);
      $this->assertEquals($user_2->name, $result->users[1]->name);
    }
}