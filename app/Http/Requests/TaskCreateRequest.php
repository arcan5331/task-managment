<?php

namespace App\Http\Requests;

use App\Enums\TaskSuperiority;
use App\Enums\TaskStatus;
use App\Rules\JalaliDate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'min:2'],
            'du_date' => ['required', new JalaliDate()],
            'description' => ['nullable', 'min:2'],
            'superiority' => ['nullable', Rule::enum(TaskSuperiority::class)],
            'status' => ['nullable', Rule::enum(TaskStatus::class)],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
