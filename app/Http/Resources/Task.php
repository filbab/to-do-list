<?php

namespace App\Http\Resources;

use App\Http\Resources\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Domain\Task\Entities\Models\Task $resource
 */
class Task extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->getId(),
            'title' => $this->resource->getTitle(),
            'description' => $this->resource->getDescription(),
            'status' => $this->resource->getStatus(),
            'created_at' => $this->resource->getCreatedAt(),
            'users' => User::collection($this->resource->getUsers())
        ];
    }
}
