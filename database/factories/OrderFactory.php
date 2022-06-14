<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Order;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return[
            'name'=> $this->faker->name(),
            'details'=> $this->faker->text(50)
        ];
    }
}
