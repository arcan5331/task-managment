<?php

namespace App\Http\Requests;

use App\Enums\TaskSuperiority;
use App\Enums\TaskStatus;
use App\Rules\JalaliDate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'nullable|exists:users,id',
            'title' => 'nullable|string|min:2|max:50',
            'description' => 'nullable|string|min:2',
            'status' => ['nullable', Rule::enum(TaskStatus::class)],
            'superiority' => ['nullable', Rule::enum(TaskSuperiority::class)],
            'du_date' => ['nullable', new JalaliDate()],
        ];
    }
}
