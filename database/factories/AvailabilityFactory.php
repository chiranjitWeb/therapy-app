<?php
namespace Database\Factories;

use App\Models\Availability;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\AvailabilityStatus;

class AvailabilityFactory extends Factory
{
    protected $model = Availability::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('+1 day', '+1 month');
        $end = (clone $start)->modify('+1 hour');

        $statuses = [
            AvailabilityStatus::Empty,
            AvailabilityStatus::Booked,
            AvailabilityStatus::Blocked,
        ];

        return [
            'therapist_id' => User::inRandomOrder()->first()?->id, // only therapists in seeder
            'starts_at' => $start,
            'ends_at' => $end,
            'status' => $statuses[array_rand($statuses)], // assign enum instance
        ];
    }
}
