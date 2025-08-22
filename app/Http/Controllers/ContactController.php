<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Mail\ContactFormSubmitted;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        // Custom validation: must be either email OR phone
        $request->validate([
            'name'    => 'required|string|max:255',
            'contact' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    // Check if value is valid email
                    if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        return true;
                    }
                    // Check if value looks like phone number (basic regex for digits, +, -, space)
                    if (preg_match('/^\+?[0-9\s\-]{7,20}$/', $value)) {
                        return true;
                    }
                    // Otherwise fail
                    $fail('The '.$attribute.' must be a valid email address or phone number.');
                }
            ],
            'message' => 'required|string|min:10',
        ]);

        // Store in database
        $contact = Contact::create([
            'name'    => $request->name,
            'contact' => $request->contact, // changed from email to contact
            'message' => $request->message,
        ]);

        // Send email notification to admin (optional: include contact instead of email)
        Mail::to(config('mail.admin_address'))->send(
            new ContactFormSubmitted($contact)
        );

        return back()->with('success', 'Thank you for your message. We will respond soon.');
    }
}
