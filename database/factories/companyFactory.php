<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\company;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\company>
 */
class companyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'company_name' => $this -> faker -> company,
            'street_address' => $this -> faker -> streetAddress,
            'representative_name' => $this -> faker -> name,
            'created_at' => $this -> faker -> dateTime,
            'updated_at' => $this -> faker -> dateTime,
        ];
    }
}
