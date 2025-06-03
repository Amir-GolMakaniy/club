<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'first_name' => $this->faker->firstName(),
			'last_name' => $this->faker->lastName(),
			'national_code' => $this->faker->unique()->buildingNumber(),
			'birth_date' => $this->faker->date(),
			'phone' => $this->faker->phoneNumber(),
		];
	}
}
