<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermintaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        \App\Models\Permintaan::factory(10)
            ->has(
                \App\Models\DetailPermintaan::factory()->count( rand(1,6) )
                , 'details'
            )
            ->create();
    }
}
