<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password123'),
                'role' => 'admin'
            ]
        );

        // Create Manager User
        User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Manager User',
                'password' => bcrypt('password123'),
                'role' => 'manager'
            ]
        );

        // Create Regular User
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'password' => bcrypt('password123'),
                'role' => 'user'
            ]
        );

        $this->call(FileCategorySeeder::class);
        $this->call(DirectorDivisionSeeder::class);
        $this->call(DepartmentFileSeeder::class);
    }
}
