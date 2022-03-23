<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'name'              => $this->faker->name,
        'email'             => $this->faker->email,
        'email_verified_at' => null,
        'provider_id'       => 'a9db6107-648a-44cc-a5fd-f796727b1a09',
        'provider'          => 'azure',
        'password'          => null
        ];
    }
}
