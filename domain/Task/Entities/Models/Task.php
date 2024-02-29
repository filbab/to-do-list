<?php

declare(strict_types=1);

namespace Domain\Task\Entities\Models;

use Carbon\Carbon;
use App\Models\Task as BaseModel;
use Illuminate\Support\Collection;
use Domain\Task\Entities\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends BaseModel
{
   public function getId(): int
   {
      return $this->id;
   }

   public function getTitle(): string
   {
      return $this->title;
   }

   public function getDescription(): ?string
   {
      return $this->description;
   }

   public function getStatus(): string
   {
      return $this->status;
   }

   public function getUsers(): Collection
   {
      return $this->users;
   }

   public function getCreatedAt(): Carbon
   {
      return $this->created_at;
   }

   public function users(): BelongsToMany
   {
      return $this->belongsToMany(User::class, 'user_task');
   }

   // Scopes
   public function scopeByTitle(Builder $query, ?string $title): void
   {
      $query->where('title', 'like', '%'.$title.'%');
   }

   public function scopeByStatus(Builder $query, ?string $status): void
   {
      $query->where('status', $status);
   }

   public function scopeByUserIds(Builder $query, ?array $user_ids): void
   {
      $query->whereHas('users', function (Builder $query) use ($user_ids) {
         $query->whereIn('user_id', $user_ids);
      });
   }
}