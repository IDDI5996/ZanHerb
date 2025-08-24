<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    // Public service listing with categories
    public function publicIndex()
    {
        $categories = Service::getCategories();
        $servicesByCategory = [];
        
        foreach ($categories as $category) {
            $servicesByCategory[$category] = Service::active()
                ->byCategory($category)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();
        }

        $featuredServices = Service::active()
            ->featured()
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('services.index', compact('servicesByCategory', 'categories', 'featuredServices'));
    }

    // Public service detail
    public function publicShow(Service $service)
    {
        if (!$service->is_active) {
            abort(404);
        }

        // Get related services from the same category
        $relatedServices = Service::active()
            ->byCategory($service->category)
            ->where('id', '!=', $service->id)
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('services.show', compact('service', 'relatedServices'));
    }
    
    // Admin index
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Service::getCategories();
        $icons = [
            'chat-bubble', 'stethoscope', 'heartbeat', 'leaf', 
            'heart', 'tint', 'brain', 'venus-mars', 
            'mortar-pestle', 'users', 'seedling', 'microscope',
            'book-open', 'flask', 'lightbulb', 'vial',
            'project-diagram', 'female', 'handshake', 'network-wired',
            'video', 'pump-medical', 'shield'
        ];
        
        return view('admin.services.create', compact('categories', 'icons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'long_description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'icon' => 'nullable|string',
            'secondary_icon' => 'nullable|string',
            'is_active' => 'boolean',
            'featured' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully!');
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
    public function edit(Service $service)
    {
        $categories = Service::getCategories();
        $icons = [
            'chat-bubble', 'stethoscope', 'heartbeat', 'leaf', 
            'heart', 'tint', 'brain', 'venus-mars', 
            'mortar-pestle', 'users', 'seedling', 'microscope',
            'book-open', 'flask', 'lightbulb', 'vial',
            'project-diagram', 'female', 'handshake', 'network-wired',
            'video', 'pump-medical', 'shield'
        ];
        
        return view('admin.services.edit', compact('service', 'categories', 'icons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'long_description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'icon' => 'nullable|string',
            'secondary_icon' => 'nullable|string',
            'is_active' => 'boolean',
            'featured' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully!');
    }
}