<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChirpFactory extends Factory
{
    protected $model = \App\Models\Chirp::class;

    public function definition()
    {
        return [
            'content' => $this->faker->sentence(),
            'user_id' => \App\Models\User::factory(), // Associe chaque chirp à un utilisateur
            'created_at' =>now(),
        ];
    }
}
