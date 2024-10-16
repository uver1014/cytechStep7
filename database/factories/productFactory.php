<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\product;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\product>
 */
class productFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'company_id' => $this -> faker -> numberBetween($min = 1, $max = 3),
            'product_name' => $this -> faker -> word(10),
            'price' => $this -> faker -> numberBetween($min = 100, $max = 200),
            'stock' => $this -> faker -> numberBetween($min = 0, $max = 15),
            'comment' => $this -> faker -> text(30),
            'created_at' => $this -> faker -> dateTime,
            'updated_at' => $this -> faker -> dateTime
        ];
    }
}
