<?php

namespace Tests\Unit;

use App\Models\ConversionStat;
use App\Services\ConversionServiceInterface;
use Tests\TestCase;

class ConvertIntegerCommandTest extends TestCase
{
    public function test_command_successful_conversion(): void
    {
        $convertedNumber = new ConversionStat(['roman' => 'XXX']);

        $mock = $this->mock(ConversionServiceInterface::class, function ($mock) use ($convertedNumber) {
            $mock->shouldReceive('convertAndRecord')
                ->once()
                ->with(30)
                ->andReturn($convertedNumber);
        });

        $this->artisan('roman:convert 30')
            ->expectsOutput('Converted 30 to Roman: XXX')
            ->assertExitCode(0);
    }

    public function test_command_invalid_input(): void
    {
        $this->artisan('roman:convert 0')
            ->expectsOutputToContain('Conversion Failed')
            ->assertExitCode(1);
    }
}
