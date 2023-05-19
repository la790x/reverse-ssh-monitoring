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
        $names = ['disconnect', 'connected', 'request terminate', 'pid server terminated', 'plink terminated'];

        foreach ($names as $value) {
            ConnectionStatus::create([
                'name' => $value
            ]);
        }
    }
}
