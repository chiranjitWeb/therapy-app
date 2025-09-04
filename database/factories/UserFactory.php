<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Addiction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // default
            'remember_token' => Str::random(10),
            'addiction_id' => Addiction::inRandomOrder()->first()?->id, // link addiction
        ];
    }
}

