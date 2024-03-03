<?php

declare(strict_types=1);

namespace Domain\Task\Queries;

use Illuminate\Support\Collection;
use Domain\Task\Entities\Models\Task;
use App\Http\Requests\Interfaces\IShowTasksRequest;

class TaskQuery
{
   private Task $task;

   public function __construct()
   {
      $this->task = new Task();
   }

   public function getTasks(IShowTasksRequest $request): ?Collection
   {
      $query = $this->task::query();
      
      if ($request->getTitle()) {
         $query->byTitle($request->getTitle());
      }

      if ($request->getStatus()) {
         $query->byStatus($request->getStatus());
      }

      if ($request->getUserIds()) {
         $query->byUserIds($request->getUserIds());
      }

      return $query->get();
   }
}