<?php

namespace Database\Seeders;

use App\Models\Partnership;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partnerships = Partnership::pluck('id')->toArray();
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
                'partnership_id' => $partnerships[array_rand($partnerships)],
            ],
            [
                'name' => 'Mock',
                'email' => 'mock@mock.com',
                'password' => bcrypt('password'),
                'partnership_id' => $partnerships[array_rand($partnerships)],
            ]
        ];
        foreach($users as $user) {
            User::firstOrCreate($user);
        }
    }
}
