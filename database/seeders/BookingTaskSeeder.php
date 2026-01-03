<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingTask;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingTaskSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookings = Booking::all();

        if ($bookings->isEmpty()) {
            return;
        }

        foreach ($bookings as $booking) {
            $taskCount = fake()->numberBetween(3, 6);
            for ($i = 0; $i < $taskCount; $i++) {
                BookingTask::create([
                    'booking_id' => $booking->id,
                    'task_name' => fake()->words(3, true),
                    'start_date' => $booking->start_date,
                    'end_date' => fake()->dateTimeBetween($booking->start_date, $booking->end_date),
                    'pic' => fake()->name(),
                    'order' => $i + 1,
                ]);
            }
        }
    }
}
