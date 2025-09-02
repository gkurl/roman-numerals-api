<?php

namespace App\Validation;

class ConversionValidationRules
{

    // Static here so it can be shared across Request AND CLI command
    public static function rules(): array
    {
        return [
            'integer' => 'required|integer|between:1,3999',
        ];
    }

    public static function messages(): array
    {
        return [
            'integer.integer' => 'The :attribute must be a number between 1 and 3999.',
            'integer.between' => 'The :attribute must be between 1 and 3999.',
        ];
    }
}
