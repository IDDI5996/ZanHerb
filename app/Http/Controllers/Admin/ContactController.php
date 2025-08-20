<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactResponse;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::latest()->paginate(10);
        $unrespondedCount = Contact::where('responded', false)->count();
        
        return view('admin.contacts.index', compact('contacts', 'unrespondedCount'));
    }
    
    public function respond(Request $request, Contact $contact)
    {
        $request->validate([
            'response' => 'required|string|min:10',
        ]);

        // Update the contact record
        $contact->update([
            'admin_response' => $request->response,
            'responded' => true,
        ]);

        // Send email response
        Mail::to($contact->email)->send(new ContactResponse($contact));

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Response sent successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact message deleted successfully');
    }
}
