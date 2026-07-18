<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Classes;
use App\Models\User;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FeeVoucher>
 */
class FeeVoucherFactory extends Factory
{
    public function definition(): array
    {
        $student = User::factory()->create();
        $student->assignRole(Role::firstOrCreate(['name' => 'Student']));

        $class = Classes::first() ?? Classes::create([
            'name' => 'Class 1',
            'numeric_value' => 1,
        ]);

        return [
            'voucher_number' => 'FV-' . $this->faker->unique()->numerify('######'),
            'user_id' => $student->id,
            'class_id' => $class->id,
            'academic_session' => date('Y') . '-' . (date('Y') + 1),
            'billing_month' => date('F Y'),
            'amount' => $this->faker->numberBetween(1000, 5000),
            'due_date' => now()->addDays(10),
            'status' => 'unpaid',
            'paid_at' => null,
        ];
    }
}
