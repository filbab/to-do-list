<?php

namespace App\Http\Resources\Task;

use Illuminate\Http\Resources\Json\JsonResource;

class Task extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->getId(),
            'title' => $this->resource->getName(),
            'description' => $this->resource->getImage(),
            'status' => $this->resource->getBlurhash(),
        ];
    }
}
