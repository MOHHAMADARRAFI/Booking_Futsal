<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function process(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking is not pending');
        }

        return view('payments.process', compact('booking'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'payment_method' => 'required|in:cash,card,bank_transfer,e_wallet',
        ]);

        $booking = Booking::findOrFail($validated['booking_id']);

        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'amount' => $booking->total_price,
            'payment_method' => $validated['payment_method'],
            'status' => 'completed',
            'transaction_id' => 'TRX-' . time() . '-' . auth()->id(),
        ]);

        $booking->update(['status' => 'confirmed']);

        return redirect()->route('bookings.show', $booking)->with('success', 'Payment processed successfully');
    }

    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $payments = Payment::with('booking', 'booking.user', 'booking.court')->latest()->paginate(15);
        return view('payments.index', compact('payments'));
    }
}
