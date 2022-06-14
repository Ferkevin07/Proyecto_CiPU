<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Provider;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Providers>
 */
class ProviderFactory extends Factory
{
    protected $model = Provider::class;

    public function definition()
    {
        return[
            'name'=> $this->faker->name(),
            'first_name'=>$this->faker->firstName(),
            'last_name'=>$this->faker->lastName(),
            'direction'=>$this->faker->streetAddress(),
            'description' => $this->faker->text(40),
        ];
    }
}
