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

    public function test_rejects_out_of_range_and_invalid(): void
    {
        $validator = Validator::make(['integer' => 0], ConversionValidationRules::rules());
        $this->assertTrue($validator->fails());

        $validator = Validator::make(['integer' => 4000], ConversionValidationRules::rules());
        $this->assertTrue($validator->fails());

        $validator = Validator::make(['integer' => 'abc'], ConversionValidationRules::rules());
        $this->assertTrue($validator->fails());
    }
}
