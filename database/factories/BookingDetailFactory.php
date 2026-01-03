<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookingDetail>
 */
class BookingDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'service_name' => $this->faker->randomElement(['MC Formal', 'MC Non Formal', 'Stage', 'Sound System', 'Lighting', 'Decoration']),
            'price' => $this->faker->numberBetween(500000, 5000000),
            'notes' => $this->faker->sentence(),
        ];
    }
}
