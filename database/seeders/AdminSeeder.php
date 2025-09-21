<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'SkipLine',
            'email' => 'admin@skipline.com',
            'role' => 'admin',
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'password' => Hash::make('password12'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        $this->command->info('  Admin accounts created successfully!');
        $this->command->line('  1. admin@skipline.com:password12');
    }
}
