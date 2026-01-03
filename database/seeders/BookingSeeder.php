<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a customer user
        $customer = User::where('email', 'user@cakrawala.com')->first()
            ?? User::factory()->create([
                'email' => 'user@cakrawala.com',
                'name' => 'Customer User',
                'role' => 'user',
            ]);

        // Create 5 bookings with details and tasks
        for ($i = 0; $i < 5; $i++) {
            $booking = Booking::create([
                'user_id' => $customer->id,
                'customer_name' => fake()->name(),
                'customer_email' => fake()->unique()->safeEmail(),
                'customer_phone' => fake()->phoneNumber(),
                'pic_contact' => fake()->name(),
                'event_name' => fake()->words(3, true),
                'start_date' => fake()->dateTimeBetween('+1 day', '+30 days'),
                'end_date' => fake()->dateTimeBetween('+31 days', '+60 days'),
                'location' => fake()->address(),
                'notes' => fake()->sentence(),
                'proposal_file' => 'proposals/sample.pdf',
                'admin_status' => fake()->randomElement(['review', 'detail_sent', 'final_approved', 'on_progress', 'finished']),
                'customer_status' => fake()->randomElement(['submitted', 'detail_approved', 'final_signed']),
            ]);

            // Create 2-4 booking details for each booking
            $detailCount = fake()->numberBetween(2, 4);
            for ($j = 0; $j < $detailCount; $j++) {
                $booking->details()->create([
                    'service_name' => fake()->randomElement(['MC Formal', 'MC Non Formal', 'Stage', 'Sound System', 'Lighting', 'Decoration']),
                    'price' => fake()->numberBetween(500000, 5000000),
                    'notes' => fake()->sentence(),
                ]);
            }

            // Create 3-6 booking tasks for each booking
            $taskCount = fake()->numberBetween(3, 6);
            for ($k = 0; $k < $taskCount; $k++) {
                $booking->tasks()->create([
                    'task_name' => fake()->words(3, true),
                    'start_date' => $booking->start_date,
                    'end_date' => fake()->dateTimeBetween($booking->start_date, $booking->end_date),
                    'pic' => fake()->name(),
                    'order' => $k + 1,
                ]);
            }
        }
    }
}
