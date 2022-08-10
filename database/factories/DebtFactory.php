<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Debt;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Debts>
 */
class DebtFactory extends Factory
{
    protected $model = Debt::class;

    public function definition()
    {
        return[
            'to_pay'=>$this->faker->boolean(),
            'to_collect'=>$this->faker->boolean(),
            'details'=> $this->faker->text(50),
            'price'=> $this->faker->randomFloat(2, 0, 100),
            'state'=>$this->faker->boolean()
        ];
    }
}
