<?php

namespace Database\Factories;

use App\Models\Wallet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class WalletFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Wallet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' =>  User::factory()->create()->id,
            'amount_of_satoshi' => $this->faker->randomNumber(6, false),
            'address' =>  $this->faker->regexify('[A-Z]{5}[0-4]{3}'),
            //'amount_of_satoshi' => 50000,
        ];
    }
}
