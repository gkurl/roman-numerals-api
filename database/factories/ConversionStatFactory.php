<?php

namespace Database\Factories;

use App\Models\ConversionStat;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversionStatFactory extends Factory
{
    protected $model = ConversionStat::class;

    public function definition(): array
    {
        return [
            'integer_value' => $this->faker->numberBetween(1, 3999),
            'roman' => 'I',
            'conversions_count' => $this->faker->numberBetween(1, 100),
            'last_converted_at' => now(),
        ];
    }
}
