<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Task\Queries\TaskQuery\GetTasks;

use Tests\TestCase;
use App\Models\User;
use App\Models\TaskStatus;
use Domain\Task\Queries\TaskQuery;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TaskQueryTest extends TestCase
{
   use DatabaseTransactions;
   use TaskQueryTrait;

   private TaskQuery $query;

   protected function setUp(): void
   {
      parent::setUp();

      $this->query = $this->app->make(TaskQuery::class);
   }

   /**
    * @feature Tasks
    * @scenario Get Tasks
    * @case No tasks exist

    * @expectation Return empty collection
    * @test
    */
    public function getTasks_noTasksExist_returnEmptyCollection(): void
    {
       // GIVEN
       $request = $this->mockRequest();
 
       // WHEN
       $result = $this->query->getTasks($request);
       
       // THEN
       $this->assertCount(0, $result);
    }

    /**
    * @feature Tasks
    * @scenario Get Tasks
    * @case Multiple tasks exist

    * @expectation Return all tasks
    * @test
    */
    public function getTasks_multipleTasksExist_returnAllTasks(): void
    {
       // GIVEN
       $task_1 = $this->createTask(['title' => 'Task 1']);
       $task_2 = $this->createTask(['title' => 'Task 2']);
       $task_3 = $this->createTask(['title' => 'Something to do']);

       $request = $this->mockRequest();
 
       // WHEN
       $result = $this->query->getTasks($request);
       
       // THEN
       $this->assertCount(3, $result);
    }

    /**
    * @feature Tasks
    * @scenario Get Tasks
    * @case Multiple tasks exist, filter by title

    * @expectation Return filtered tasks
    * @test
    */
    public function getTasks_multipleTasksExistFilterByTitle_returnFilteredTasks(): void
    {
       // GIVEN
       $task_1 = $this->createTask(['title' => 'Task 1']);
       $task_2 = $this->createTask(['title' => 'Task 2']);
       $task_3 = $this->createTask(['title' => 'Something to do']);

       $request = $this->mockRequest(title: 'task');
 
       // WHEN
       $result = $this->query->getTasks($request);
       
       // THEN
       $this->assertCount(2, $result);
    }

    /**
    * @feature Tasks
    * @scenario Get Tasks
    * @case Multiple tasks exist, filter by user ids

    * @expectation Return filtered tasks
    * @test
    */
    public function getTasks_multipleTasksExistFilterByUserIds_returnFilteredTasks(): void
    {
       // GIVEN
       $user_1 = User::factory()->create();
       $user_2 = User::factory()->create();

       $task_1 = $this->createTask([]);
       $task_2 = $this->createTask([], [$user_1->id, $user_2->id]);
       $task_3 = $this->createTask([]);

       $request = $this->mockRequest(user_ids: [$user_2->id]);
 
       // WHEN
       $result = $this->query->getTasks($request);
       
       // THEN
       $this->assertCount(1, $result);
       $this->assertEquals($result->first()->users->first()->id, $user_1->id);
    }

    /**
    * @feature Tasks
    * @scenario Get Tasks
    * @case Multiple tasks exist, filter by status

    * @expectation Return filtered tasks
    * @test
    */
    public function getTasks_multipleTasksExistFilterByStatus_returnFilteredTasks(): void
    {
       // GIVEN
       $status_1 = TaskStatus::factory()->create();
       $status_2 = TaskStatus::factory()->create();

       $task_1 = $this->createTask(['status_id' => $status_2->id]);
       $task_2 = $this->createTask(['status_id' => $status_1->id]);
       $task_3 = $this->createTask(['status_id' => $status_2->id]);

       $request = $this->mockRequest(status: $status_2->name);
 
       // WHEN
       $result = $this->query->getTasks($request);
       
       // THEN
       $this->assertCount(2, $result);
    }
}