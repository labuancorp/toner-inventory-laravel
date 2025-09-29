<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    protected $signature = 'user:create-test';
    protected $description = 'Create a test user account';

    public function handle()
    {
        $email = 'test@example.com';
        $password = 'password';
        
        // Check if user already exists
        if (User::where('email', $email)->exists()) {
            $this->info("Test user already exists with email: {$email}");
            $this->info("Password: {$password}");
            return;
        }

        // Create test user
        $user = User::create([
            'name' => 'Test User',
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        $this->info("Test user created successfully!");
        $this->info("Email: {$email}");
        $this->info("Password: {$password}");
        $this->info("Role: user");
    }
}
