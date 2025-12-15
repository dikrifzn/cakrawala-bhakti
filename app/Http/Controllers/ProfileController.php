<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('pages.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui');
    }

    public function bookings()
    {
        $user = Auth::user();
        $bookings = Booking::where('user_id', $user->id)
            ->with(['eventType', 'services'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('pages.profile.bookings', compact('bookings', 'user'));
    }

    public function showBooking($id)
    {
        $booking = Booking::findOrFail($id);
        
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $booking->load([
            'eventType', 
            'services' => function($query) {
                $query->where(function($q) {
                    $q->whereHas('creator', function($subQuery) {
                        $subQuery->where('role', 'admin');
                    })
                    ->orWhere('created_by', Auth::id())
                    ->orWhereNull('created_by');
                });
            },
            'bookingServices.service'
        ]);

        return view('pages.profile.booking-detail', compact('booking'));
    }
}
