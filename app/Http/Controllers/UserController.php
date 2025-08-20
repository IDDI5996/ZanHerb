<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Notification;

class UserController extends Controller
{
    public function dashboard()
    {
        // Extra security layer (commented out as in your original)
        // if (!auth()->user()->is_active) {
        //     auth()->logout();
        //     return redirect()->route('login')->with('error', 'Account disabled.');
        // }
    
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
         
        // Get user bookings
        $bookings = Booking::where('user_id', auth()->id())
                          ->where('is_archived', false)
                          ->with(['product', 'service'])
                          ->latest()
                          ->get();
        
        // Get active services
        $services = Service::where('is_active', true)
                          ->orderBy('name')
                          ->get();
        
        // Get approved products (limit to 3 for the dashboard)
        $products = Product::where('tmda_status', 'approved')
                          ->orderBy('name')
                          ->limit(1)
                          ->get();
        
        // Get current promotions
        $promotions = Promotion::active()
                              ->latest()
                              ->get();
        
        // Get active notifications for all users
        $notifications = Notification::where('is_active', true)
                                   ->latest()
                                   ->get();
        
        return view('dashboard', compact('bookings', 'services', 'products', 'promotions', 'notifications'));
    }
}