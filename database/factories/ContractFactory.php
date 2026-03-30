<?php

namespace Database\Factories;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'reference' => 'ECO-' . $this->faker->unique()->numerify('######'),
            'start_date' => $this->faker->dateTimeBetween('-3 years', '-1 year'),
            'end_date' => $this->faker->boolean(20) ? $this->faker->dateTimeBetween('-11 months', 'now') : null,
            'amount' => $this->faker->randomFloat(2, 30, 150),
        ];
    }
}
