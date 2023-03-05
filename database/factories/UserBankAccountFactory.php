<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserBankAccount>
 */
class UserBankAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->name(),
            'account_number' => fake()->numberBetween(1100000040, 8999999990),
            'bank_code' => fake()->numberBetween(100,999),
            'currency' => fake()->currencyCode(),
            'account_type' => fake()->randomElement(["nuban","mobile_money"])
        ];
    }
}
