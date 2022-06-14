<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name'=> $this->faker->firstName(),
            'last_name'=> $this->faker->lastName(),
            'username'=> $this->faker->name(),
            'personal_phone'=> '09'.$this->faker->randomNumber(8),
            'home_phone'=> '02'.$this->faker->randomnumber(7),
            'address'=> $this->faker->streetAddress(),
            'birthdate'=>$this->faker->dateTimeBetween('-50 years','now'),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('secreto'),
            'remember_token' => Str::random(10)
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
