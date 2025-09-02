<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StatsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'limit' => 'nullable|integer|min:1|max:' . config('roman.max_stats_limit')
        ];
    }

    public function messages(): array {
        return [
            'limit.integer' => 'Limit must be an integer.',
            'limit.min' => 'Limit must be at least 1.',
            'limit.max' => 'Limit cannot exceed ' . config('roman.max_stats_limit') . '.',
        ];
    }

    //Helper function for limit extraction in other parts of the code if required
    public function validatedLimit(): int {
        return (int) ($this->validated()['limit'] ?? config('roman.max_stats_limit'));
    }
}
