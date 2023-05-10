<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if ('local' == config('app.env')) {
            \App\Models\User::factory()->create([
                'name' => 'latief',
                'email' => 'latif@visiglobalteknologi.co.id',
                'password' => bcrypt('12345678')
            ]);
        }
    }
}
