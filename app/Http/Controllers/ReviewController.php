<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status !== 'completed') {
            return back()->with('error', 'Can only review completed bookings');
        }

        if ($booking->review()->exists()) {
            return back()->with('error', 'You already reviewed this booking');
        }

        return view('reviews.create', compact('booking'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $booking = Booking::findOrFail($validated['booking_id']);

        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->review()->exists()) {
            return back()->with('error', 'You already reviewed this booking');
        }

        Review::create([
            'booking_id' => $booking->id,
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'Review posted successfully');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $bookingId = $review->booking_id;
        $review->delete();

        return redirect()->route('bookings.show', $bookingId)->with('success', 'Review deleted successfully');
    }
}
