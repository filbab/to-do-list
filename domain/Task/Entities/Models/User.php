<?php

declare(strict_types=1);

namespace Domain\Task\Entities\Models;

use App\Models\User as BaseModel;

class User extends BaseModel
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