<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Addiction;
use App\Models\Availability;
use App\Models\Meeting;
use App\Models\MeetingRequest;
use App\Enums\AvailabilityStatus;
use App\Enums\MeetingType;
use App\Enums\MeetingSubType;
use App\Enums\MeetingRequestStatus;

class InitSeeder extends Seeder
{
    public function run(): void
    {
       
        // Roles

        $adminRole     = Role::firstOrCreate(['name' => 'admin'], ['display_name' => 'Admin']);
        $therapistRole = Role::firstOrCreate(['name' => 'therapist'], ['display_name' => 'Therapist']);
        $userRole      = Role::firstOrCreate(['name' => 'user'], ['display_name' => 'User']);

       
        // Addictions

        Addiction::firstOrCreate(['name' => 'Alcohol']);
        Addiction::firstOrCreate(['name' => 'Smoking']);
        Addiction::firstOrCreate(['name' => 'Drugs']);

     
        // Admin

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->roles()->attach($adminRole);

        
        // Therapists
        
        $therapists = User::factory(5)->create()->each(fn($t) => $t->roles()->attach($therapistRole));
        
        // Users
      
        $users = User::factory(20)->create()->each(fn($u) => $u->roles()->attach($userRole));

        // Availabilities (default Empty)
      
        $availabilities = Availability::factory(30)->create([
            'status' => AvailabilityStatus::Empty,
        ])->each(function ($a) use ($therapists) {
            $a->therapist_id = $therapists->random()->id;
            $a->save();
        });

        // Meetings
        
        $availabilitiesWithMeetings = $availabilities->random(15); // pick 15 to attach meetings

        foreach ($availabilitiesWithMeetings as $availability) {
            // Decide random type
            $type = fake()->randomElement([MeetingType::OneOnOne, MeetingType::Lecture]);

            if ($type === MeetingType::OneOnOne) {
                $subtype = fake()->randomElement([MeetingSubType::Online, MeetingSubType::Onsite]);
                $user = $users->random();

                Meeting::factory()->create([
                    'availability_id' => $availability->id,
                    'type' => $type,
                    'subtype' => $subtype,
                    'user_id' => $user->id,
                    'starts_at' => $availability->starts_at,
                    'ends_at' => $availability->ends_at,
                    'title' => fake()->sentence(3),
                ]);

                // Mark availability as booked
                $availability->status = AvailabilityStatus::Booked;
                $availability->save();
            } else {
                // Lecture type, no user/subtype
                Meeting::factory()->create([
                    'availability_id' => $availability->id,
                    'type' => MeetingType::Lecture,
                    'subtype' => null,
                    'user_id' => null,
                    'starts_at' => $availability->starts_at,
                    'ends_at' => $availability->ends_at,
                    'title' => fake()->sentence(3),
                ]);

                // Lecture can keep status empty or booked based on your rules
                $availability->status = AvailabilityStatus::Booked;
                $availability->save();
            }
        }

        // Meeting Requests

        foreach ($availabilities->random(15) as $availability) {
            MeetingRequest::factory()->create([
                'availability_id' => $availability->id,
                'therapist_id' => $availability->therapist_id,
                'message' => fake()->sentence(8),
                'status' => MeetingRequestStatus::Open, // use enum
            ]);
        }
    }
}

