<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Court;
use App\Models\User;

class CourtSeeder extends Seeder
{
    public function run(): void
    {
        $owner1 = User::where('email', 'owner1@booking.test')->first();
        $owner2 = User::where('email', 'owner2@booking.test')->first();

        // Courts for Owner 1
        Court::create([
            'name' => 'Lapangan Futsal A',
            'description' => 'Lapangan futsal berkualitas dengan fasilitas modern dan lengkap',
            'price_per_hour' => 150000,
            'capacity' => 4,
            'location' => 'Jl. Merdeka No. 123, Jakarta',
            'image_url' => 'https://via.placeholder.com/400x200?text=Lapangan+A',
            'status' => 'active',
            'owner_id' => $owner1->id,
        ]);

        Court::create([
            'name' => 'Lapangan Futsal B',
            'description' => 'Lapangan futsal premium dengan pencahayaan LED terbaik',
            'price_per_hour' => 200000,
            'capacity' => 4,
            'location' => 'Jl. Sudirman No. 456, Jakarta',
            'image_url' => 'https://via.placeholder.com/400x200?text=Lapangan+B',
            'status' => 'active',
            'owner_id' => $owner1->id,
        ]);

        // Courts for Owner 2
        Court::create([
            'name' => 'Lapangan Futsal C',
            'description' => 'Lapangan futsal dengan area parkir yang luas',
            'price_per_hour' => 120000,
            'capacity' => 4,
            'location' => 'Jl. Gatot Subroto No. 789, Jakarta',
            'image_url' => 'https://via.placeholder.com/400x200?text=Lapangan+C',
            'status' => 'active',
            'owner_id' => $owner2->id,
        ]);

        Court::create([
            'name' => 'Lapangan Futsal D',
            'description' => 'Lapangan futsal ekonomis untuk pemain pemula',
            'price_per_hour' => 100000,
            'capacity' => 4,
            'location' => 'Jl. Ahmad Yani No. 101, Jakarta',
            'image_url' => 'https://via.placeholder.com/400x200?text=Lapangan+D',
            'status' => 'active',
            'owner_id' => $owner2->id,
        ]);
    }
}
