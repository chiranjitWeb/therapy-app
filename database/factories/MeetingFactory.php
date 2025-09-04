<?php 
namespace Database\Factories;

use App\Models\Meeting;
use App\Models\User;
use App\Models\Availability;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\MeetingType;
use App\Enums\MeetingSubType;

class MeetingFactory extends Factory
{
    protected $model = Meeting::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('+1 day', '+1 month');
        $end = (clone $start)->modify('+1 hour');

        
         // Pick meeting type
         $types = [
            MeetingType::OneOnOne,
            MeetingType::Lecture,
        ];
        $type = $types[array_rand($types)];

        // Subtype only for 1-on-1
        $subtypes = [
            MeetingSubType::Online,
            MeetingSubType::Onsite,
        ];
        $subtype = $type === MeetingType::OneOnOne
            ? $subtypes[array_rand($subtypes)]
            : null;

        $user_id = $type === MeetingType::OneOnOne
        ? User::whereHas('roles', fn($q) => $q->where('name', 'user'))->inRandomOrder()->first()?->id
        : null; //Only consider users where their related roles have name = 'user'...

        return [
            'availability_id' => Availability::inRandomOrder()->first()?->id,
            'type' => $type,      
            'subtype' => $subtype,
            'title' => $this->faker->sentence(3),
            'user_id' => $user_id,
            'starts_at' => $start,
            'ends_at' => $end,
        ];
    }
}
