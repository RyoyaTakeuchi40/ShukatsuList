<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class InterviewFactory extends Factory
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
            'interview' => $this->faker->date(),
            'note' => $this->faker->sentence(),
            'result' => $this->faker->numberBetween(0, 4),
        ];
    }
}
