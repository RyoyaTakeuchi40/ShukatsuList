<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class SelectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => Company::factory(),
            'es' => $this->faker->date(),
            'es_note' => $this->faker->sentence(),
            'es_result' => $this->faker->numberBetween(0, 4),
            'test' => $this->faker->date(),
            'test_type' => $this->faker->numberBetween(1, 5),
            'test_note' => $this->faker->sentence(),
            'test_result' => $this->faker->numberBetween(0, 4),
            'gd' => $this->faker->date(),
            'gd_note' => $this->faker->sentence(),
            'gd_result' => $this->faker->numberBetween(0, 4),
            'result' => $this->faker->numberBetween(0, 4),
        ];
    }
}
