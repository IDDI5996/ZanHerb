<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\BookingsExport; // Make sure to import this
use Maatwebsite\Excel\Facades\Excel; // Import if using Excel export
use App\Models\Contact;
use App\Models\Notification;

class AdminController extends Controller
{
    public function index()
    {
         $activeUsers = User::where('last_active_at', '>=', now()->subMinutes(15))
        ->orderBy('last_active_at', 'desc')
        ->limit(2)
        ->get();
        
        $activeUsersCount = User::where('last_active_at', '>=', now()->subMinutes(15))->count();
        
        // Get recent feedbacks (limited to 2 for dashboard)
        $feedbacks = Feedback::with('user')
            ->latest()
            ->take(2)
            ->get();

        // Get recent bookings (limited to 2 for dashboard)
        $recentBookings = Booking::with(['user', 'product'])
            ->latest()
            ->take(2)
            ->get();
        
        //Get contact data
        $recentContacts = Contact::latest()
            ->limit(2)
            ->get();
        $unrespondedContactsCount = Contact::where('responded', false)->count();
    
        //Get active notifications
        $activeNotifications = Notification::where('is_active', true)
            ->latest()
            ->limit(2)
            ->get();

        // Count new pending bookings from last 7 days
        $newBookingsCount = Booking::where('status', 'pending')
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->count();

        // For the full listings (used in separate views)
        $allFeedbacks = Feedback::with('user')->latest()->paginate(10);
        $allBookings = Booking::with(['user', 'product'])->latest()->paginate(10);

        return view('admin.dashboard', compact(
            'feedbacks',
            'recentBookings',
            'newBookingsCount',
            'allFeedbacks',
            'allBookings',
            'activeUsers',
            'activeUsersCount',
            'recentContacts',
            'unrespondedContactsCount',
            'activeNotifications'
        ));
    }

    public function viewBooking(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        $booking->update(['status' => $validated['status']]);
        
        // Optional: Send status update notification to user
        Mail::to($booking->email)->send(new BookingStatusUpdated($booking));

        return back()->with('success', 'Booking status updated successfully');
    }

    public function exportBookings()
    {
        return Excel::download(new BookingsExport, 'bookings-'.now()->format('Y-m-d').'.xlsx');
    }
}