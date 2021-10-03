<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sender' => $this->faker->regexify('[A-Z]{5}[0-4]{3}'),
            'recipient' => $this->faker->regexify('[A-Z]{5}[0-4]{3}'),
            'amount_of_transaction' => 11111,
            'sender_id' => User::factory()->create()->id,
        ];
    }
}
