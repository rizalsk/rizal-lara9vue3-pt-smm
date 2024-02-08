<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Departemen};

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $departemen_id = Departemen::inRandomOrder()->first()->id;        
        return [
            'nik' => hexdec(uniqid()),
            'nama' => fake()->name(),
            'departemen_id' => $departemen_id
        ];
    }
}
