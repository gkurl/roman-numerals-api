<?php

namespace Tests\Unit;

use App\Validation\ConversionValidationRules;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
class ConversionValidationRulesTest extends TestCase
{
    public function test_accepts_valid_integers(): void
    {
        $validator = Validator::make(['integer' => 123], ConversionValidationRules::rules());
        $this->assertTrue($validator->passes());
    }
}
