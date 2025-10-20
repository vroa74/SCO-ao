<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tc;

class TcSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        Tc::create([
            'tc' => 'TC-001'
        ]);

        Tc::create([
            'tc' => 'TC-002'
        ]);

        Tc::create([
            'tc' => 'TC-003'
        ]);

        Tc::create([
            'tc' => 'TC-004'
        ]);

        Tc::create([
            'tc' => 'TC-005'
        ]);
    }
}