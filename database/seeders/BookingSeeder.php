<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Court;
use App\Models\User;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        $courts = Court::all();

        // Create some test bookings
        foreach ($customers->take(3) as $customer) {
            foreach ($courts->take(2) as $court) {
                Booking::create([
                    'court_id' => $court->id,
                    'user_id' => $customer->id,
                    'booking_date' => now()->addDays(rand(1, 10)),
                    'start_time' => '09:00',
                    'end_time' => '11:00',
                    'total_price' => $court->price_per_hour * 2,
                    'status' => 'confirmed',
                ]);
            }
        }
    }
}
