<?php

namespace Database\Factories;

use App\Models\Barang;
use App\Models\Permintaan;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permintaan>
 */
class PermintaanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $staff_nik = Staff::inRandomOrder()->first()->nik ?? null;
        return [
            'staff_nik' => $staff_nik,
            'tanggal_permintaan' => now()->subDays(rand(6, 30))->format('Y-m-d H:i:s'),
            'status' => fake()->randomElement(['menunggu', 'diproses', 'selesai'])
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Permintaan $permintaan) {
            // ...
        })->afterCreating(function (Permintaan $permintaan) {
            // ...
        });
    }
}
