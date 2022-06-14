<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Manager;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Managers>
 */
class ManagerFactory extends Factory
{
    protected $model = Manager::class;

    public function definition()
    {
        $startingDate = $this->faker->dateTimeBetween('-50 years', '-10 years');
        return[
            'first_name'=> $this->faker->firstName(),
            'last_name'=> $this->faker->lastName(),
            'username'=> $this->faker->name(),
            'email'=> $this->faker->unique()->email(),
            'personal_phone'=> '09'.$this->faker->randomNumber(8),
            'home_phone'=> '02'.$this->faker->randomnumber(7),
            'address'=> $this->faker->streetAddress(),
            'birthdate'=>$this->faker->dateTimeBetween($startingDate, '- 1 year')
        ];
    }
}
