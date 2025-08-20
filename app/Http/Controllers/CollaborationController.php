<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CollaborationController extends Controller
{
    public function create()
    {
        return view('collaborations');
    }

    public function store(Request $request)
    {
        $request->validate([
            'organization' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        // In production: Store in DB or send email to admin
        return redirect()->back()->with('success', 'Your request has been received. We will get back to you shortly.');
    }
}
