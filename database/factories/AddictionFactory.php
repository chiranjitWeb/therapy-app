<?php
namespace Database\Factories;

use App\Models\Addiction;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddictionFactory extends Factory
{
    protected $model = Addiction::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
