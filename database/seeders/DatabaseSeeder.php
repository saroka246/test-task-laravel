<?php

namespace Database\Seeders;

use App\Models\OrderType;
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
        $this->call([
            PartnershipSeeder::class,
            UserSeeder::class,
            OrderTypeSeeder::class,
            WorkerSeeder::class,
            OrderSeeder::class
        ]);
    }
}
