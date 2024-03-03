<?php

declare(strict_types=1);

namespace App\Http\Requests\Interfaces;

interface IShowTasksRequest
{
   public function getTitle(): ?string;
   public function getStatus(): ?string;
   public function getUserIds(): ?array;
}