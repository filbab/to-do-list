<?php

namespace App\Http\Requests\Task;

use App\Http\Requests\Interfaces\ICreateUpdateTaskRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateTaskRequest extends FormRequest implements ICreateUpdateTaskRequest
{
    public function rules(): array
    {
        return [
            'title' => ['present', 'string'],
            'description' => ['present', 'nullable', 'string'],
            'status' => ['present', 'exists:App\Models\TaskStatus,name'],
            'user_ids' => ['present', 'array'],
            'user_ids.*' => ['integer', 'exists:App\Models\User,id']
        ];
    }

    public function getTitle(): string
    {
        return $this->input('title');
    }

    public function getDescription(): ?string
    {
        return $this->input('description');
    }

    public function getStatus(): string
    {
        return $this->input('status');
    }

    public function getUserIds(): array
    {
        return $this->input('user_ids');
    }
}
