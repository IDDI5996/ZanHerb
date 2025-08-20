<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    //User feedback submission
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000'
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'message' => $request->message
        ]);

        return back()->with('success', 'Thank you for your feedback!');
    }
     /**
     * Admin: List all feedback
     */
    public function adminIndex()
    {
        $feedbacks = Feedback::with('user')
            ->latest()
            ->paginate(10);
            
        return view('admin.feedback.index', compact('feedbacks'));
    }
    
    /**
     * Delete feedback
     */
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        
        return back()->with('success', 'Feedback deleted successfully');
    }
}
