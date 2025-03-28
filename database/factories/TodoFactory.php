<?php

namespace Database\Factories;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    protected $model = Todo::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
            'is_done' => $this->faker->boolean,
        ];
    }
}
