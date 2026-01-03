<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admins and managers can view all bookings, customers can view their own
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Booking $booking): bool
    {
        // Admins/managers can view all; customers can only view their own
        return $user->canManageBookings() || $booking->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Anyone authenticated can create a booking
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Booking $booking): bool
    {
        // Only admins and managers can update bookings
        return $user->canManageBookings();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Booking $booking): bool
    {
        // Only admins can delete bookings
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Booking $booking): bool
    {
        // Only admins can restore deleted bookings
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Booking $booking): bool
    {
        // Only admins can permanently delete
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can approve details.
     */
    public function approveDetails(User $user, Booking $booking): bool
    {
        // Customer can approve their own booking details
        return $booking->user_id === $user->id && $booking->admin_status === 'detail_sent';
    }

    /**
     * Determine whether the user can upload signature.
     */
    public function uploadSignature(User $user, Booking $booking): bool
    {
        // Customer can upload signature when final approval is ready
        return $booking->user_id === $user->id && $booking->admin_status === 'final_approved';
    }

    /**
     * Determine whether the user can manage booking workflow (admin actions).
     */
    public function manageWorkflow(User $user, Booking $booking): bool
    {
        // Only admins and managers can manage workflow
        return $user->canManageBookings();
    }
}
