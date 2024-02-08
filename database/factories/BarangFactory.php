<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Lokasi;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $lokasi_id = Lokasi::inRandomOrder()->first()->id ?? 0 ;

        return [
            'code' => fake()->regexify('[A-Z]{3}[0-4]{5}'),
            'nama' => fake()->catchPhrase(),
            'satuan' => fake()->randomElement(['Pak', 'Dus', 'Box']),
            'stock' => 700,
            'lokasi_id' => $lokasi_id,
        ];
    }
}
