<?php

declare(strict_types=1);

namespace Tests\Smoke\TaskController\Destroy;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TaskControllerTest extends TestCase
{
   use DatabaseTransactions;

   /**
    * @feature Tasks
    * @scenario Destroy task
    * @case Not logged in

    * @expectation Return unauthenticated
    * @test
    */
   public function destroy_notLoggedIn_returnUnauthenticated(): void
   {
      // GIVEN

      // WHEN
      $response = $this->json('delete', route('tasks.destroy', 123));
      
      // THEN
      $response->assertUnauthorized();
   }

   /**
    * @feature Tasks
    * @scenario Destroy task
    * @case Resource doesn't exist

    * @expectation Return not found
    * @test
    */
    public function destroy_resourceDoesntExist_returnNotFound(): void
    {
      // GIVEN
      $task = Task::factory()->create();
      $user = User::factory()->create();
      $task->delete();
 
      // WHEN
      $response = $this->actingAs($user, 'sanctum')->json('delete', route('tasks.destroy', 123));
       
      // THEN
      $response->assertNotFound();
    }

   /**
    * @feature Tasks
    * @scenario Destroy task
    * @case Task exists

    * @expectation Return no content
    * @test
    */
    public function destroy_taskExists_returnNoContent(): void
    {
      // GIVEN
      $task = Task::factory()->create();
      $user = User::factory()->create();
 
      // WHEN
      $response = $this->actingAs($user, 'sanctum')->json('delete', route('tasks.destroy', $task->id));
       
      // THEN
      $response->assertNoContent();
    }
}