<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Service;
use App\Models\BookingService;
use App\Models\SiteSetting;
use App\Models\User;
use App\Notifications\BookingCreatedNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        // Ambil services yang dibuat oleh admin atau services lama (created_by = null)
        $adminServices = Service::where(function ($query) {
            $query->whereHas('creator', function ($q) {
                $q->where('role', 'admin');
            })
            ->orWhereNull('created_by');
        })->get();
        
        return view('pages.order.index', ['adminServices' => $adminServices]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'event_name' => 'required|string|max:255',
            'event_type_id' => 'required|integer|exists:event_types,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'total_days' => 'nullable|string',
            'location' => 'nullable|string|max:500',
            'notes' => 'nullable|string',
            'services' => 'nullable|array',
            'services.*' => 'nullable|string',
        ]);

        // Convert ISO date to Y-m-d
        $startDate = isset($data['start_date']) ? substr($data['start_date'], 0, 10) : null;
        $endDate = isset($data['end_date']) ? substr($data['end_date'], 0, 10) : null;

        // Convert time to HH:MM:SS format
        $parseTime = function($t) {
            if (!$t) return null;
            $t = trim($t);
            // Handle '10:00 AM' or '15:00 PM'
            if (preg_match('/^(\d{1,2}):(\d{2}) ?([AP]M)?$/i', $t, $m)) {
                $h = (int)$m[1];
                $min = (int)$m[2];
                $ampm = isset($m[3]) ? strtoupper($m[3]) : null;
                if ($ampm === 'PM' && $h < 12) $h += 12;
                if ($ampm === 'AM' && $h === 12) $h = 0;
                return sprintf('%02d:%02d:00', $h, $min);
            }
            // Handle '15:00' or already correct
            if (preg_match('/^(\d{1,2}):(\d{2})(:(\d{2}))?$/', $t, $m)) {
                $h = (int)$m[1];
                $min = (int)$m[2];
                $sec = isset($m[4]) ? (int)$m[4] : 0;
                return sprintf('%02d:%02d:%02d', $h, $min, $sec);
            }
            return null;
        };
        $startTime = isset($data['start_time']) ? $parseTime($data['start_time']) : null;
        $endTime = isset($data['end_time']) ? $parseTime($data['end_time']) : null;

        // Extract numeric value from total_days (e.g., "8 hari" -> 8)
        $totalDays = null;
        if (isset($data['total_days']) && $data['total_days']) {
            preg_match('/\d+/', $data['total_days'], $matches);
            $totalDays = isset($matches[0]) ? (int)$matches[0] : null;
        }

        $booking = Booking::create([
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'] ?? null,
            'event_type_id' => $data['event_type_id'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'total_days' => $totalDays,
            'location' => $data['location'] ?? null,
            'notes' => $data['notes'] ?? null,
            'total_price' => 0,
            'status' => 'pending',
        ]);

        $total = 0;

        $services = $request->input('services', []);
        foreach ($services as $serviceValue) {
            // serviceValue may be 'Name' or 'Name|price' if frontend provided price
            $name = $serviceValue;
            $price = null;

            // If the serviceValue contains a pipe, split
            if (is_string($serviceValue) && str_contains($serviceValue, '|')) {
                [$name, $maybePrice] = explode('|', $serviceValue, 2);
                if (is_numeric($maybePrice)) $price = (int) $maybePrice;
            }

            $service = Service::where('service_name', $name)->first();
            if (! $service) {
                // create a lightweight service record for custom services
                $service = Service::create([
                    'service_name' => $name,
                    'short_description' => 'Custom service (created at booking)',
                    'price' => $price ?? 0,
                    'created_by' => Auth::id(),
                ]);
            }

            $finalPrice = $price ?? ($service->price ?? 0);
            $total += (int) $finalPrice;

            BookingService::create([
                'booking_id' => $booking->id,
                'service_id' => $service->id,
                'price' => $finalPrice,
                'quantity' => 1,
            ]);
        }

        $booking->total_price = $total;
        $booking->save();

        // Send notification to customer
        Notification::route('mail', $booking->customer_email)
            ->notify(new BookingCreatedNotification($booking));

        // Get email settings from database
        $settings = SiteSetting::first();
        
        // Send notification to admin email
        if ($settings && $settings->admin_email) {
            Notification::route('mail', $settings->admin_email)
                ->notify(new BookingCreatedNotification($booking));
        }

        // Send notification to manager email if exists
        if ($settings && $settings->manager_email) {
            Notification::route('mail', $settings->manager_email)
                ->notify(new BookingCreatedNotification($booking));
        }

        return redirect('/booking/success')->with('booking', $booking);
    }
}
