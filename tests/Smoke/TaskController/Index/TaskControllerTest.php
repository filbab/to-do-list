<?php

declare(strict_types=1);

namespace Tests\Smoke\TaskController\Index;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TaskControllerTest extends TestCase
{
   use DatabaseTransactions;
   use TaskControllerTrait;

   private User $user;

   /**
    * @feature Tasks
    * @scenario Show Tasks
    * @case Not logged in

    * @expectation Return unauthorized
    * @test
    */
   public function index_notLoggedIn_returnUnauthorized(): void
   {
      // GIVEN

      // WHEN
      $response = $this->getJson(route('tasks.index'));
      
      // THEN
      $response->assertUnauthorized();
   }

   /**
    * @feature Tasks
    * @scenario Show Tasks
    * @case No tasks exist

    * @expectation Return empty JSON structure
    * @test
    */
    public function index_noTasksExist_returnEmptyJsonStructure(): void
    {
       // GIVEN
       $user = User::factory()->create();
 
       // WHEN
       $response = $this->actingAs($user, 'sanctum')->getJson(route('tasks.index'));
       
       // THEN
       $response->assertOk();
       $response->assertJsonStructure($this->getExpectedEmptyJsonStructure());
    }

   /**
    * @feature Tasks
    * @scenario Show Tasks
    * @case Task exists

    * @expectation Return valid JSON structure
    * @test
    */
    public function index_taskExists_returnValidJsonStructure(): void
    {
       // GIVEN
       $task = Task::factory()->create();
       $user = User::factory()->create();
       $task->users()->attach($user);
 
       // WHEN
       $response = $this->actingAs($user, 'sanctum')->getJson(route('tasks.index'));
       
       // THEN
       $response->assertOk();
       $response->assertJsonStructure($this->getExpectedJsonStructure());
    }
}