<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Legislatura;

class LegislaturaSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        Legislatura::create([
            'legislatura' => 'IV',
            'actual' => false
        ]);

        Legislatura::create([
            'legislatura' => 'V',
            'actual' => true
        ]);

        Legislatura::create([
            'legislatura' => 'VI',
            'actual' => false
        ]);
    }
}