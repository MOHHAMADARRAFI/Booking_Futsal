<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Court;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = auth()->user()->bookings()->with('court', 'payment')->latest()->paginate(10);
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $courts = Court::where('status', 'active')->get();
        return view('bookings.create', compact('courts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'court_id' => 'required|exists:courts,id',
            'booking_date' => 'required|date|after:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $court = Court::findOrFail($validated['court_id']);

        // Check for conflicts
        $conflict = Booking::where('court_id', $validated['court_id'])
            ->where('booking_date', $validated['booking_date'])
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_time', '<=', $validated['start_time'])
                            ->where('end_time', '>=', $validated['end_time']);
                    });
            })->exists();

        if ($conflict) {
            return back()->with('error', 'Time slot already booked');
        }

        $startHour = (int) explode(':', $validated['start_time'])[0];
        $endHour = (int) explode(':', $validated['end_time'])[0];
        $hours = $endHour - $startHour;
        $totalPrice = $hours * $court->price_per_hour;

        $booking = Booking::create([
            'court_id' => $validated['court_id'],
            'user_id' => auth()->id(),
            'booking_date' => $validated['booking_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'Booking created successfully');
    }

    public function show(string $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('bookings.show', compact('booking'));
    }

    public function edit(string $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if (in_array($booking->status, ['confirmed', 'completed', 'cancelled'])) {
            return back()->with('error', 'Cannot edit this booking');
        }

        $courts = Court::where('status', 'active')->get();
        return view('bookings.edit', compact('booking', 'courts'));
    }

    public function update(Request $request, string $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'booking_date' => 'required|date|after:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Check for conflicts
        $conflict = Booking::where('court_id', $booking->court_id)
            ->where('id', '!=', $booking->id)
            ->where('booking_date', $validated['booking_date'])
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']]);
            })->exists();

        if ($conflict) {
            return back()->with('error', 'Time slot already booked');
        }

        $court = $booking->court;
        $startHour = (int) explode(':', $validated['start_time'])[0];
        $endHour = (int) explode(':', $validated['end_time'])[0];
        $hours = $endHour - $startHour;
        $totalPrice = $hours * $court->price_per_hour;

        $booking->update([
            'booking_date' => $validated['booking_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'total_price' => $totalPrice,
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'Booking updated successfully');
    }

    public function destroy(string $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        if ($booking->status === 'completed') {
            return back()->with('error', 'Cannot delete completed booking');
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('bookings.index')->with('success', 'Booking cancelled successfully');
    }
}
