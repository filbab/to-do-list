<?php

namespace Tests\Smoke\TaskController\Index;

trait TaskControllerTrait
{
   private function getExpectedJsonStructure(): array
   {
       return [
           'data' => [
                  '*' => [
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
            ],
       ];
   }

   private function getExpectedEmptyJsonStructure(): array
   {
      return [
         'data'
      ];
   }
}