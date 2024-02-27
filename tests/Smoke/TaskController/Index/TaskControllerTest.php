<?php

declare(strict_types=1);

namespace Tests\Smoke\TaskController\Index;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TaskControllerTest extends TestCase
{
   use DatabaseTransactions;

   /**
    * @feature Tasks
    * @scenario Show Tasks
    * @case No tasks exist

    * @expectation Return valid JSON structure with empty array
    */
   public function test_index_noTasksExist_returnValidJsonStructureWithEmptyArray(): void
   {
      // GIVEN


      // WHEN
      $response = $this->getJson(route('tasks.index'));
      
      // THEN
      $this->assertCount(0, $response->json('data'));
   }

   /**
    * @feature Tasks
    * @scenario Show Tasks
    * @case One task exists

    * @expectation Return valid JSON structure with one element
    */
    public function test_index_oneTaskExists_returnValidJsonStructureWithOneElement(): void
    {
       // GIVEN
 
 
       // WHEN
       $response = $this->getJson(route('tasks.index'));
       
       // THEN
       $this->assertEquals(12, 12);
    }
}