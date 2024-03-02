<?php

namespace Tests\Smoke\TaskController\Store;

use App\Models\User;
use App\Models\TaskStatus;

trait TaskControllerTrait
{
   public static function invalidIncomingData(): array
   {
      return [
         'empty data' => [
               [],
         ],
         'invalid data, no title' => [
               [
                  'description' => 'some description',
                  'status' => 'non existing status',
                  'user_ids' => 'should be an array'
               ],
         ],
      ];
   }

   private function getValidFormData(User $user, TaskStatus $status): array
   {
      return [
         'title' => 'New task',
         'description' => 'Some description',
         'status' => $status->name,
         'user_ids' => [$user->id],
      ];
   }

   private function getExpectedJsonStructure(): array
   {
       return [
           'data' => [
                  'id',
                  'title',
                  'description',
                  'status',
                  'created_at',
                  'users' => [
                     '*' => [
                        'id',
                        'name'
                     ]
                  ],
            ],
       ];
   }
}