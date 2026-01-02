<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingDetailSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookings = Booking::all();

        if ($bookings->isEmpty()) {
            return; // Skip if no bookings exist
        }

        foreach ($bookings as $booking) {
            // Create 2-4 details per booking
            $detailCount = fake()->numberBetween(2, 4);
            for ($i = 0; $i < $detailCount; $i++) {
                BookingDetail::create([
                    'booking_id' => $booking->id,
                    'service_name' => fake()->randomElement(['MC Formal', 'MC Non Formal', 'Stage', 'Sound System', 'Lighting', 'Decoration', 'Catering', 'Photography']),
                    'price' => fake()->numberBetween(500000, 5000000),
                    'notes' => fake()->sentence(),
                ]);
            }
        }
    }
}
