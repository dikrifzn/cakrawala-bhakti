<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Notification;
use App\Notifications\BookingCreatedNotification;
use App\Notifications\BookingStatusUpdatedNotification;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get admin users
        $admins = User::where('role', 'admin')->get();
        
        if ($admins->isEmpty()) {
            $this->command->warn('No admin users found. Creating sample admin...');
            $admin = User::create([
                'name' => 'Admin Demo',
                'email' => 'admin@cakrawalabhakti.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
            $admins = collect([$admin]);
        }

        // Get or create sample bookings
        $bookings = Booking::take(3)->get();
        
        if ($bookings->isEmpty()) {
            $this->command->warn('No bookings found. Notifications will not be seeded.');
            return;
        }

        $this->command->info('Seeding sample notifications...');

        // Create sample notifications for each admin
        foreach ($admins as $admin) {
            // New booking notification
            if ($bookings->count() > 0) {
                $admin->notify(new BookingCreatedNotification($bookings->first()));
                $this->command->info("✓ Created 'new booking' notification for {$admin->name}");
            }

            // Status updated notification
            if ($bookings->count() > 1) {
                $admin->notify(new BookingStatusUpdatedNotification($bookings->get(1)));
                $this->command->info("✓ Created 'status updated' notification for {$admin->name}");
            }

            // Another new booking
            if ($bookings->count() > 2) {
                $admin->notify(new BookingCreatedNotification($bookings->get(2)));
                $this->command->info("✓ Created another 'new booking' notification for {$admin->name}");
            }
        }

        $this->command->info('✔ Notification seeding completed!');
    }
}
