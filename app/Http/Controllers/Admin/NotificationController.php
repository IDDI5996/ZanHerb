<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = Notification::latest()->paginate(10);
        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.notifications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ]);

    // Handle checkbox explicitly
    $validated['is_active'] = $request->has('is_active');

    Notification::create($validated);

    return redirect()->route('admin.notifications.index')
        ->with('success', 'Notification created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        return view('admin.notifications.edit', compact('notification'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        ]);

        // Handle checkbox explicitly
        $notification->update([
        'title' => $validated['title'],
        'content' => $validated['content'],
        'is_active' => $request->has('is_active')
        ]);

    return redirect()->route('admin.notifications.index')
        ->with('success', 'Notification updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();
        
        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification deleted successfully');
    }
}
