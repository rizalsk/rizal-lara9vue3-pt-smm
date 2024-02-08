<?php

namespace Database\Factories;

use App\Models\{DetailPermintaan, Barang};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetailPermintaan>
 */
class DetailPermintaanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $barang_id = Barang::inRandomOrder()->first()->id;
        return [
            'kuantiti' => rand(6, 8),
            //'keterangan' => null,
            'status' => 'terpenuhi',
            'barang_id' => $barang_id
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (DetailPermintaan $permintaan) {
            // ...
        })->afterCreating(function (DetailPermintaan $permintaan) {
            $barang = Barang::where('id', $permintaan->barang_id)
            ->first();
            $barang->stock = $barang->stock - $permintaan->kuantiti;
            $barang->save();
        });
    }
}
