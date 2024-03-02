<?php

declare(strict_types=1);

namespace Tests\Smoke\TaskController\Update;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TaskControllerTest extends TestCase
{
   use DatabaseTransactions;
   use TaskControllerTrait;

   /**
    * @feature Tasks
    * @scenario Update Task
    * @case Not logged in

    * @expectation Return unauthenticated
    * @test
    */
    public function update_notLoggedIn_returnUnauthenticated(): void
    {
       // GIVEN
 
 
       // WHEN
       $response = $this->json('put', route('tasks.update', 123));
       
       // THEN
       $response->assertUnauthorized();
    }
 
    /**
     * @feature Tasks
     * @scenario Update Tasks
     * @case Invalid data provided
 
     * @expectation Return validation error
     * @dataProvider invalidIncomingData
     * @test
     */
     public function update_invalidDataProvided_returnValidationError(array $invalid_data): void
     {
        // GIVEN
        $task = Task::factory()->create();
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');
  
        // WHEN
        $response = $this->actingAs($user, 'sanctum')->json('put', route('tasks.update', $task->id), $invalid_data);
        
        // THEN
        $response->assertStatus(422);
     }

     /**
     * @feature Tasks
     * @scenario Update Tasks
     * @case Resource doesn't exist
 
     * @expectation Return not found
     * @test
     */
    public function update_resourceDoesntExist_returnNotFound(): void
    {
       // GIVEN
       $task = Task::factory()->create();
       $user = User::factory()->create();
       $task->delete();
 
       // WHEN
       $response = $this->actingAs($user, 'sanctum')->json('put', route('tasks.update', $task->id));
       
       // THEN
       $response->assertNotFound();
    }
 
     /**
     * @feature Tasks
     * @scenario Update Tasks
     * @case Valid data provided
 
     * @expectation Return updated resource
     * @test
     */
     public function update_validDataProvided_returnUpdatedResource(): void
     {
        // GIVEN
        $task = Task::factory()->create();
        $user = User::factory()->create();
        $task->users()->attach($user);
        $another_status = TaskStatus::factory()->create();
 
        $form_data = $this->getValidFormData($user, $another_status);
  
        // WHEN
        $response = $this->actingAs($user, 'sanctum')->json('put', route('tasks.update', $task->id), $form_data);
        
        // THEN
        $response->assertOk();
        $response->assertJsonStructure($this->getExpectedJsonStructure());
     }
}