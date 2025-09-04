<?php 
namespace Database\Factories;

use App\Models\MeetingRequest;
use App\Models\User;
use App\Models\Availability;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\MeetingRequestStatus;

class MeetingRequestFactory extends Factory
{
    protected $model = MeetingRequest::class;

    public function definition(): array
    {
        return [
            'availability_id' => Availability::inRandomOrder()->first()?->id,
            'therapist_id' => User::inRandomOrder()->first()?->id,
            'message' => $this->faker->sentence(),
            'status' => MeetingRequestStatus::Open, // enum instance
        ];
    }
}
