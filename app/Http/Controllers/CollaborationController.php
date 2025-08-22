<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collaborator;
use App\Models\User; // <-- Make sure you import your User model
use Illuminate\Support\Facades\Mail;
use App\Mail\CollaboratorNotification; // We'll create this Mailable

class CollaborationController extends Controller
{
    public function create()
    {
        return view('collaborations');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        // Save collaborator to DB
        $collaborator = Collaborator::create($validated);

        // Get all admins
        $admins = User::where('is_admin', true)->get();

        // Notify admins via email
        if ($admins->isNotEmpty()) {
            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new CollaboratorNotification($collaborator));
            }
        }

        return redirect()->back()->with('success', 'Your request has been received. We will get back to you shortly.');
    }
}
