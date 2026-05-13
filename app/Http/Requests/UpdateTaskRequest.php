<?php
// Same rules as StoreTaskRequest but title uniqueness ignores the task being edited

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required', 'string', 'max:255',
                Rule::unique('tasks')
                    ->where('user_id', auth()->id())
                    ->ignore($this->task->id),
            ],
            'description' => ['nullable', 'string'],
            'due_date'    => ['nullable', 'date', 'after_or_equal:today'],
            'priority'    => ['required', Rule::in(['low', 'medium', 'high'])],
            'status'      => ['sometimes', Rule::in(['pending', 'completed', 'expired'])],
        ];
    }
}
