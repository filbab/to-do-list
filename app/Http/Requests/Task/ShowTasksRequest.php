<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class ShowTasksRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'string',
            'status' => 'string',
            'user_ids' => 'array',
            'user_ids.*' => 'integer'
        ];
    }

    public function getTitle(): ?string
    {
        return $this->input('title');
    }

    public function getStatus(): ?string
    {
        return $this->input('status');
    }

    public function getUserIds(): ?array
    {
        return $this->input('user_ids');
    }
}
