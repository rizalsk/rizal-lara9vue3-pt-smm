<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailPermintaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\DetailPermintaan::factory(10)
            ->sequence(fn($sequence) => [
                'keterangan' => 'detail permintaan seeder ' . $sequence->index,
                'permintaan_id' => \App\Models\Permintaan::inRandomOrder()->first()->id,
            ])
            //->for(\App\Models\Permintaan::factory()->create(), 'permintaan' )
            ->create();
    }
}
