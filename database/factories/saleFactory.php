<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\sale>
 */
class saleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_id' => $this -> faker -> numberBetween($min = 1000, $max = 2000),
            'created_at' => $this -> faker -> dateTime,
            'updated_at' => $this -> faker -> dateTime
        ];
    }
}
