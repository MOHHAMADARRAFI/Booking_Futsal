<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class OwnerDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('owner');
    }

    public function index()
    {
        $user = auth()->user();
        $courts = $user->courts;
        $bookings = Booking::whereIn('court_id', $courts->pluck('id'))->get();
        
        $totalRevenue = Payment::whereIn('booking_id', $bookings->pluck('id'))
            ->where('status', 'completed')
            ->sum('amount');
        
        $pendingBookings = $bookings->where('status', 'pending')->count();
        $completedBookings = $bookings->where('status', 'completed')->count();

        return view('owner.dashboard', compact('courts', 'bookings', 'totalRevenue', 'pendingBookings', 'completedBookings'));
    }
}
