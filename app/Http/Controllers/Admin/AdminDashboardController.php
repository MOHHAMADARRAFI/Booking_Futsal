<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Court;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $totalCourts = Court::count();
        $totalBookings = Booking::count();
        $totalUsers = User::count();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $pendingBookings = Booking::where('status', 'pending')->count();
        $recentBookings = Booking::with('user', 'court')->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalCourts',
            'totalBookings',
            'totalUsers',
            'totalRevenue',
            'pendingBookings',
            'recentBookings'
        ));
    }
}
