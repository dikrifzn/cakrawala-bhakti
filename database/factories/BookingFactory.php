<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('+1 day', '+30 days');
        $endDate = $this->faker->dateTimeBetween($startDate, '+60 days');

        return [
            'user_id' => User::factory(),
            'customer_name' => $this->faker->name(),
            'customer_email' => $this->faker->unique()->safeEmail(),
            'customer_phone' => $this->faker->phoneNumber(),
            'pic_contact' => $this->faker->name(),
            'event_name' => $this->faker->words(3, true),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'location' => $this->faker->address(),
            'notes' => $this->faker->sentence(),
            'proposal_file' => 'proposals/sample.pdf',
            'admin_status' => $this->faker->randomElement(['review', 'detail_sent', 'final_approved', 'on_progress', 'finished', 'rejected']),
            'customer_status' => $this->faker->randomElement(['submitted', 'detail_approved', 'final_signed', 'rejected']),
            'approved_by' => null,
            'approved_at' => null,
            'approval_ip' => null,
            'proposal_file' => null,
            'proposal_description' => null,
            'signature_file' => null,
            'approval_file' => null,
            'gantt_chart' => null,
        ];
    }
}
