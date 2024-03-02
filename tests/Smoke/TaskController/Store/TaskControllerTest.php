<?php

declare(strict_types=1);

namespace Tests\Smoke\TaskController\Store;

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
    * @scenario Store Task
    * @case Not logged in

    * @expectation Return unauthenticated
    * @test
    */
   public function store_notLoggedIn_returnUnauthenticated(): void
   {
      // GIVEN


      // WHEN
      $response = $this->getJson(route('tasks.store'));
      
      // THEN
      $response->assertUnauthorized();
   }

   /**
    * @feature Tasks
    * @scenario Show Tasks
    * @case Invalid data provided

    * @expectation Return validation error
    * @dataProvider invalidIncomingData
    * @test
    */
    public function store_invalidDataProvided_returnValidationError(array $invalid_data): void
    {
       // GIVEN
       $user = User::factory()->create();
       $this->actingAs($user, 'sanctum');
 
       // WHEN
       $response = $this->json('post', route('tasks.store'), $invalid_data);
       
       // THEN
       $response->assertStatus(422);
    }

    /**
    * @feature Tasks
    * @scenario Show Tasks
    * @case Valid data provided

    * @expectation Return newly created resource
    * @test
    */
    public function store_validDataProvided_returnNewlyCreatedResource(): void
    {
       // GIVEN
       $user = User::factory()->create();
       $status = TaskStatus::factory()->create();

       $form_data = $this->getValidFormData($user, $status);
 
       // WHEN
       $response = $this->actingAs($user, 'sanctum')->json('post', route('tasks.store'), $form_data);
       
       // THEN
       $response->assertCreated();
       $response->assertJsonStructure($this->getExpectedJsonStructure());
    }
}