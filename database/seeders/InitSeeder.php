<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Addiction;
use Laratrust\Models\Role;
use Laratrust\Models\Permission;

class InitSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['display_name' => 'Admin']);
        $therapistRole = Role::firstOrCreate(['name' => 'therapist'], ['display_name' => 'Therapist']);
        $userRole = Role::firstOrCreate(['name' => 'user'], ['display_name' => 'User']);

        // Addictions
        Addiction::firstOrCreate(['name' => 'Alcohol']);
        Addiction::firstOrCreate(['name' => 'Smoking']);
        Addiction::firstOrCreate(['name' => 'Drugs']);

        // Users
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->roles()->attach($adminRole); // ✅ updated

        $therapist = User::factory()->create([
            'name' => 'Therapist User',
            'email' => 'therapist@example.com',
            'password' => bcrypt('password'),
        ]);
        $therapist->roles()->attach($therapistRole); // ✅ updated

        $user = User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->roles()->attach($userRole); // ✅ updated
    }
}
