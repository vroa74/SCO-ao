<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Nc;

class NcSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        Nc::create([
            'nc' => 'NC-001'
        ]);

        Nc::create([
            'nc' => 'NC-002'
        ]);

        Nc::create([
            'nc' => 'NC-003'
        ]);

        Nc::create([
            'nc' => 'NC-004'
        ]);

        Nc::create([
            'nc' => 'NC-005'
        ]);
    }
}