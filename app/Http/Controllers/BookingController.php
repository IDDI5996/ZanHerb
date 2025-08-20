<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingNotification;
use App\Mail\BookingCancelled;
use App\Mail\BookingConfirmed;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function allUserBookings(Request $request)
    {
        $bookings = auth()->user()->bookings()
            ->with(['product', 'service'])
            ->when($request->status, function($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->when($request->from_date, function($query) use ($request) {
                return $query->where('preferred_date', '>=', $request->from_date);
            })
            ->when($request->to_date, function($query) use ($request) {
                return $query->where('preferred_date', '<=', $request->to_date);
            })
            ->when(!$request->has('show_archived'), function($query) {
                $query->where('is_archived', false);
            })
            ->orderBy('preferred_date', 'desc')
            ->paginate(10);

        return view('bookings.all', compact('bookings'));
    }

    public function archive(Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);
        
        $booking->update([
            'is_archived' => !$booking->is_archived
        ]);

        return back()->with('success', $booking->is_archived ? 'Booking archived successfully' : 'Booking unarchived successfully');
    }

    // Show booking form
    public function create(Request $request)
    {
        $products = Product::approved()->get();
        
        // Get selected product from URL parameter
        $selectedProductId = null;
        if ($request->has('product_id')) {
            $selectedProduct = Product::approved()->find($request->product_id);
            if ($selectedProduct) {
                $selectedProductId = $selectedProduct->id;
            }
        }

        return view('bookings.create', [
            'products' => $products,
            'selectedProductId' => $selectedProductId
        ]);
    }

    // Store new booking
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'condition' => 'required|string|max:1000',
            'preferred_date' => 'required|date|after_or_equal:today',
            'preferred_time' => 'required',
            'product_id' => 'nullable|exists:products,id'
        ]);

        // Check for duplicate bookings
        $existingBooking = Booking::where('email', $validated['email'])
                                ->where('preferred_date', $validated['preferred_date'])
                                ->where('preferred_time', $validated['preferred_time'])
                                ->exists();

        if ($existingBooking) {
            return back()->withInput()->with('error', 'You already have a booking at this date and time.');
        }

        $bookingData = [
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'condition' => $validated['condition'],
            'preferred_date' => $validated['preferred_date'],
            'preferred_time' => $validated['preferred_time'],
            'status' => Booking::STATUS_PENDING
        ];

        // Only add product_id if it exists and is valid
        if ($validated['product_id']) {
            $product = Product::approved()->find($validated['product_id']);
            if ($product) {
                $bookingData['product_id'] = $product->id;
            }
        }

        $booking = Booking::create($bookingData);

        // Notify admins
        $admins = User::where('is_admin', true)->get();
        if ($admins->isNotEmpty()) {
            Mail::to($admins)->send(new BookingNotification($booking));
        }

        // Send confirmation to user
        Mail::to($booking->email)->send(new BookingNotification($booking, true));

        return redirect()->route('dashboard')
               ->with('success', 'Your consultation has been booked! We will contact you shortly.');
    }

    // Admin: List all bookings
    public function adminIndex(Request $request)
    {
        $query = Booking::with(['user', 'product'])
                      ->latest();
    
        // Enhanced filtering
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('date_from')) {
            $query->where('preferred_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('preferred_date', '<=', $request->date_to);
        }
    
        $bookings = $query->paginate(10)
                         ->appends($request->query());
    
        return view('admin.bookings.index', compact('bookings'));
    }

    // Admin: Show single booking
    public function show(Booking $booking)
    {
        // Add related bookings for context
        $relatedBookings = Booking::where('email', $booking->email)
                                ->where('id', '!=', $booking->id)
                                ->latest()
                                ->take(5)
                                ->get();

        return view('admin.bookings.show', compact('booking', 'relatedBookings'));
    }

    // Admin: Update booking status
    public function confirm(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);
        Mail::to($booking->email)->send(new BookingConfirmed($booking));
    return back()->with('success', 'Booking confirmed!');
    }

    public function cancelAdmin(Request $request, Booking $booking)
    {
        $validated = $request->validate(['cancellation_reason' => 'required|max:500']);
        $booking->update([
            'status' => 'cancelled',
            'cancellation_reason' => $validated['cancellation_reason']
    ]);
        Mail::to($booking->email)->send(new BookingCancelled($booking));
    return back()->with('success', 'Booking cancelled!');
    }

    // User can cancel their own booking
    public function cancel(Request $request, Booking $booking)
    {
        abort_unless(auth()->id() === $booking->user_id, 403);
        
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $booking->update([
            'status' => Booking::STATUS_CANCELLED,
            'cancellation_reason' => $request->reason
        ]);

        // Notify admins
        User::where('is_admin', true)->each(function ($admin) use ($booking) {
            Mail::to($admin->email)->send(new BookingCancelled($booking, 'User cancelled'));
        });

        return back()->with('success', 'Your booking has been cancelled.');
    }
    
     //User Show single booking
    public function shows(Booking $booking)
    {
        // Add related bookings for context
        $relatedBookings = Booking::where('email', $booking->email)
                                ->where('id', '!=', $booking->id)
                                ->latest()
                                ->take(5)
                                ->get();

        return view('bookings.show', compact('booking', 'relatedBookings'));
    }
}