<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\FeeVoucher;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'fee_voucher_id' => FeeVoucher::factory(),
            'amount' => $this->faker->randomFloat(2, 100, 5000),
            'method' => $this->faker->randomElement(['cash', 'bank', 'other']),
            'reference_number' => null,
            'note' => null,
            'collected_by' => null,
            'paid_at' => now(),
            'voided_at' => null,
            'voided_by' => null,
        ];
    }

    public function voided(): static
    {
        return $this->state(fn () => [
            'voided_at' => now(),
        ]);
    }
}
