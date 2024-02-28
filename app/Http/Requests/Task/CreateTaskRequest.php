<?php

namespace App\Http\Requests\Task;

use Illuminate\Validation\Rule;
use App\Models\Descriptors\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'string',
            'description' => 'string',
            'status' => [Rule::enum(TaskStatus::class)],
            'user_ids' => 'array'
        ];
    }

    public function getTitle(): string
    {
        return $this->input('title');
    }

    public function getDescription(): string
    {
        return $this->input('title');
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
