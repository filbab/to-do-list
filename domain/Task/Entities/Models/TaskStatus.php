<?php

declare(strict_types=1);

namespace Domain\Task\Entities\Models;

use App\Models\TaskStatus as BaseModel;
use Illuminate\Database\Eloquent\Builder;

class TaskStatus extends BaseModel
{
   public function getId(): int
   {
      return $this->id;
   }

   public function getName(): string
   {
      return $this->name;
   }
}