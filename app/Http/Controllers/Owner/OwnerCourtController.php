<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Models\Booking;
use Illuminate\Http\Request;

class OwnerCourtController extends Controller
{
    public function __construct()
    {
        $this->middleware('owner');
    }

    public function index()
    {
        $user = auth()->user();
        $courts = $user->courts()->paginate(10);
        return view('owner.courts.index', compact('courts'));
    }

    public function create()
    {
        return view('owner.courts.create');
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

        return redirect()->route('owner.courts.index')->with('success', 'Court created successfully');
    }

    public function show(Court $court)
    {
        if ($court->owner_id !== auth()->id()) {
            abort(403);
        }

        $bookings = $court->bookings()->latest()->paginate(10);
        return view('owner.courts.show', compact('court', 'bookings'));
    }

    public function edit(Court $court)
    {
        if ($court->owner_id !== auth()->id()) {
            abort(403);
        }

        return view('owner.courts.edit', compact('court'));
    }

    public function update(Request $request, Court $court)
    {
        if ($court->owner_id !== auth()->id()) {
            abort(403);
        }

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
        return redirect()->route('owner.courts.show', $court)->with('success', 'Court updated successfully');
    }

    public function destroy(Court $court)
    {
        if ($court->owner_id !== auth()->id()) {
            abort(403);
        }

        $court->delete();
        return redirect()->route('owner.courts.index')->with('success', 'Court deleted successfully');
    }
}
