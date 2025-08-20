<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    
    /**
     * Display a listing of active promotions for public view
     */
    public function publicIndex()
    {
        $promotions = Promotion::where('is_active', true)
            ->where('end_date', '>=', now())
            ->orderBy('start_date', 'desc')
            ->get();

        return view('promotions.index', compact('promotions'));
    }
    
    public function index()
    {
        $promotions = Promotion::latest()->paginate(10);
        return view('admin.promotions.index', compact('promotions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.promotions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('promotions', 'public');
        }

        Promotion::create($validated);

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promotion created successfully!');
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
    public function edit(Promotion $promotion)
    {
        return view('admin.promotions.edit', compact('promotion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {
         $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($promotion->image_path);
            $validated['image_path'] = $request->file('image')->store('promotions', 'public');
        }

        $promotion->update($validated);

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promotion updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        // Delete associated image
        Storage::disk('public')->delete($promotion->image_path);
        
        $promotion->delete();

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promotion deleted successfully!');
    }
}
