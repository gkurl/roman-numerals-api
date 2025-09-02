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
            'integer.between' => 'The integer must be between 1 and 3999.',
        ];
    }
}
