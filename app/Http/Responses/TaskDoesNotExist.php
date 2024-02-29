<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;

class TaskDoesNotExist implements Responsable
{
   public function toResponse($request)
   {
      return new JsonResponse([
         'message' => 'Task with given id does not exist!'
      ], 404);
   }
}