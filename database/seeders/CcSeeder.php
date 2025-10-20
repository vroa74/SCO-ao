<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cc;
use App\Models\Tc;

class CcSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener los TCs existentes
        $tcs = Tc::all();
        
        if ($tcs->count() > 0) {
            // Crear CCs para cada TC
            foreach ($tcs as $tc) {
                // Crear 2-3 CCs por cada TC
                for ($i = 1; $i <= 2; $i++) {
                    Cc::create([
                        'tc_id' => $tc->id,
                        'ccor' => 'CC-' . str_pad($tc->id, 3, '0', STR_PAD_LEFT) . '-' . str_pad($i, 2, '0', STR_PAD_LEFT)
                    ]);
                }
            }
        } else {
            // Si no hay TCs, crear algunos TCs de ejemplo y luego CCs
            $tc1 = Tc::create(['tc' => 'TC-001']);
            $tc2 = Tc::create(['tc' => 'TC-002']);
            
            Cc::create(['tc_id' => $tc1->id, 'ccor' => 'CC-001-01']);
            Cc::create(['tc_id' => $tc1->id, 'ccor' => 'CC-001-02']);
            Cc::create(['tc_id' => $tc2->id, 'ccor' => 'CC-002-01']);
            Cc::create(['tc_id' => $tc2->id, 'ccor' => 'CC-002-02']);
        }
    }
}
