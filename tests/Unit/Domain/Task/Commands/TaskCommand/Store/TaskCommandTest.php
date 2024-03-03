<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Task\Commands\TaskCommand\Store;

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
    * @scenario Store task
    * @case Valid data provided with one user

    * @expectation Return newly created task
    * @test
    */
    public function store_validDataProvidedWithOneUser_returnNewlyCreatedTask(): void
    {
      // GIVEN
      $user = User::factory()->create();

      $status = TaskStatus::factory()->create();

      $request = $this->mockRequest(
         title: "New Task",
         description: "Very important task",
         status: $status->name,
         user_ids: [$user->id]
      );
 
      // WHEN
      $result = $this->command->store($request);
       
       // THEN
      $this->assertEquals("New Task", $result->title);
      $this->assertEquals("Very important task", $result->description);
      $this->assertEquals($status->name, $result->status->name);
      $this->assertCount(1, $result->users);
      $this->assertEquals($user->name, $result->users->first()->name);
    }

    /**
    * @feature Tasks
    * @scenario Store task
    * @case Valid data provided with multiple users

    * @expectation Return newly created task with users
    * @test
    */
    public function store_validDataProvidedWithMultipleUser_returnNewlyCreatedTaskWithUsers(): void
    {
      // GIVEN
      $user_1 = User::factory()->create();
      $user_2 = User::factory()->create();
      $user_3 = User::factory()->create();

      $status = TaskStatus::factory()->create();

      $request = $this->mockRequest(
         title: "New Task",
         description: "Very important task",
         status: $status->name,
         user_ids: [$user_1->id, $user_2->id, $user_3->id]
      );
 
      // WHEN
      $result = $this->command->store($request);
       
       // THEN
      $this->assertEquals("New Task", $result->title);
      $this->assertEquals("Very important task", $result->description);
      $this->assertEquals($status->name, $result->status->name);
      $this->assertCount(3, $result->users);
      $this->assertEquals($user_1->name, $result->users[0]->name);
      $this->assertEquals($user_2->name, $result->users[1]->name);
      $this->assertEquals($user_3->name, $result->users[2]->name);
    }
}