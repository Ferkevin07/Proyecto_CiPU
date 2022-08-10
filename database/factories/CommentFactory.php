<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Comment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comments>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return[
            'details'=> $this->faker->text(50),
            'ranking'=> $this->faker->numberBetween($min=1, $max=5),
            
            //randomElement(['high','mediun','low']);
        ];
    }
}
