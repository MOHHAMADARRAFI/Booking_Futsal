<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\Booking;
use Illuminate\Http\Request;

class CourtController extends Controller
{
    public function index()
    {
        $courts = Court::where('status', 'active')->get();
        return view('courts.index', compact('courts'));
    }

    public function show(string $id)
    {
        $court = Court::findOrFail($id);
        $reviews = $court->bookings()
            ->whereHas('review')
            ->with('review')
            ->latest()
            ->paginate(5);

        return view('courts.show', compact('court', 'reviews'));
    }

    public function create()
    {
        return view('courts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_hour' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'image_url' => 'nullable|url',
        ]);

        $validated['owner_id'] = auth()->id();
        Court::create($validated);

        return redirect()->route('courts.index')->with('success', 'Court created successfully');
    }

    public function edit(string $id)
    {
        $court = Court::findOrFail($id);
        return view('courts.edit', compact('court'));
    }

    public function update(Request $request, string $id)
    {
        $court = Court::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_hour' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'image_url' => 'nullable|url',
            'status' => 'required|in:active,inactive',
        ]);

        $court->update($validated);
        return redirect()->route('courts.show', $court)->with('success', 'Court updated successfully');
    }

    public function destroy(string $id)
    {
        $court = Court::findOrFail($id);
        $court->delete();

        return redirect()->route('courts.index')->with('success', 'Court deleted successfully');
    }
}
