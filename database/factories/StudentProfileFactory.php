<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentProfile>
 */
class StudentProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create([
        'role_id' => Role::firstOrCreate(['name' => 'Student'])->id, 
    ]);

    return [
        'user_id' => $user->id,
        'class_id' => 1, 
        'roll_number' => 'R-' . $this->faker->unique()->numberBetween(1000, 9999),
        'admission_date' => $this->faker->date(),
        'cnic' => $this->faker->unique()->numerify('#####-#######-#'),
        'date_of_birth' => $this->faker->date(),
        'gender' => $this->faker->randomElement(['male', 'female']),
        'guardian_name' => $this->faker->name(),
        'guardian_phone' => $this->faker->phoneNumber(),
        'address' => $this->faker->address(),
    ];
    }
}
