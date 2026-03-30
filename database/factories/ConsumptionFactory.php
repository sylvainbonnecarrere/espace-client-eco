<?php

namespace Database\Factories;

use App\Models\Consumption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Consumption>
 */
class ConsumptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contract_id' => \App\Models\Contract::factory(),
            'month' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m'),
            'value' => $this->faker->randomFloat(2, 50, 500),
        ];
    }
}
