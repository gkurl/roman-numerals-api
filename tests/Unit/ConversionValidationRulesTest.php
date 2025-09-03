<?php

namespace Tests\Unit;

use App\Validation\ConversionValidationRules;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
class ConversionValidationRulesTest extends TestCase
{
    public function testAcceptsValidIntegers(): void
    {
        $validator = Validator::make(['integer' => 123], ConversionValidationRules::rules());
        $this->assertTrue($validator->passes());
    }

    public function testRejectsOutOfRangeAndInvalid(): void
    {
        $validator = Validator::make(['integer' => 0], ConversionValidationRules::rules());
        $this->assertTrue($validator->fails());

        $validator = Validator::make(['integer' => 4000], ConversionValidationRules::rules());
        $this->assertTrue($validator->fails());

        $validator = Validator::make(['integer' => 'abc'], ConversionValidationRules::rules());
        $this->assertTrue($validator->fails());
    }
}
