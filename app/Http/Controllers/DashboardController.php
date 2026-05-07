<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isOwner()) {
            return $this->ownerDashboard();
        } else {
            return $this->customerDashboard();
        }
    }

    private function adminDashboard()
    {
        $totalCourts = Court::count();
        $totalBookings = Booking::count();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $pendingBookings = Booking::where('status', 'pending')->count();

        return view('dashboard.admin', compact('totalCourts', 'totalBookings', 'totalRevenue', 'pendingBookings'));
    }

    private function ownerDashboard()
    {
        $user = auth()->user();
        $courts = $user->courts;
        $bookings = Booking::whereIn('court_id', $courts->pluck('id'))->get();
        $totalRevenue = Payment::whereIn('booking_id', $bookings->pluck('id'))
            ->where('status', 'completed')
            ->sum('amount');

        return view('dashboard.owner', compact('courts', 'bookings', 'totalRevenue'));
    }

    private function customerDashboard()
    {
        $user = auth()->user();
        $bookings = $user->bookings()->with('court')->latest()->paginate(10);
        $upcomingBookings = $user->bookings()->where('booking_date', '>=', today())->count();

        return view('dashboard.customer', compact('bookings', 'upcomingBookings'));
    }
}
