<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Form edit profil
     */
    public function edit()
    {
        return view('pages.profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update profil user
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * List booking milik user
     */

    public function bookings()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(10);

        // Bisa tambahkan eager loading untuk rincian, gantt, dsb jika sudah ada relasi/model

        return view('pages.profile.bookings', [
            'user'     => Auth::user(),
            'bookings' => $bookings,
        ]);
    }

    /**
     * Detail booking
     */
    public function showBooking($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Contoh: eager load rincian, gantt, PIC jika sudah ada relasi/model
        // $booking->load(['details', 'gantt', 'pic']);

        return view('pages.profile.booking-detail', [
            'booking' => $booking,
            // 'details' => $booking->details,
            // 'gantt' => $booking->gantt,
            // 'pic' => $booking->pic,
        ]);
    }
}
