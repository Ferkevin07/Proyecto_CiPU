<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return[
            'name'=> $this->faker->title(),
            'stock'=> $this->faker->numberBetween($min=1, $max=50),
            'description' => $this->faker->text(40),
            'price_min'=>$this->faker->randomFloat(2, 0, 60),
            'price_max'=>$this->faker->randomFloat(2, 60, 120)
        ];
    }
}
