<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookingTask>
 */
class BookingTaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $booking = Booking::factory();
        $startDate = $booking->start_date ?? $this->faker->dateTimeBetween('+1 day', '+30 days');
        $endDate = $this->faker->dateTimeBetween($startDate, '+10 days');

        return [
            'booking_id' => $booking,
            'task_name' => $this->faker->words(3, true),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'pic' => $this->faker->name(),
            'order' => $this->faker->numberBetween(1, 10),
        ];
    }
}
