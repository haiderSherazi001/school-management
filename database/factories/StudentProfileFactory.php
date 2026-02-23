<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Spatie\Permission\Models\Role; 

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentProfile>
 */
class StudentProfileFactory extends Factory
{
    public function definition(): array
    {
        $user = User::factory()->create();

        $studentRole = Role::firstOrCreate(['name' => 'Student']);
        $user->assignRole($studentRole);

        // 4. Return the profile data linked to the new user.
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