<?php

namespace Database\Seeders;

use App\Models\Settings;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
       $user= User::factory()->create([
            'name' => 'TestUser',
            'email' => 'testuser@example.com',
            'password' => Hash::make('password'),
        ]);
        Settings::create([
            'user_id' => $user->id,
            'company_name' => "Invozen App",
        ]);
        UserDetail::create([
            'user_id' => $user->id,
            'country' => 'Bangladesh',
        ]);

        $this->call([
            AdminSeeder::class,
            PlanSeeder::class,
        ]);
    }
}
