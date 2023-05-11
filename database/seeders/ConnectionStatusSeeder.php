<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConnectionStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ConnectionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['waiting', 'connected', 'terminated', 'request terminate'];

        foreach ($names as $value) {
            ConnectionStatus::create([
                'name' => $value
            ]);
        }
    }
}
