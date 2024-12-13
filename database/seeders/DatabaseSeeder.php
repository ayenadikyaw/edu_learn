<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Clear existing records
        User::truncate();
        
        // Run AdminSeeder only if admin doesn't exist
        if (!User::where('email', 'admin@example.com')->exists()) {
            $this->call([
                AdminSeeder::class,
            ]);
        }
    }
}
