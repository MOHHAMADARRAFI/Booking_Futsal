@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4">Dashboard Pelanggan</h1>

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="dashboard-stat">
                <div class="stat-number">{{ $upcomingBookings }}</div>
                <div class="stat-label">Pemesanan Mendatang</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="dashboard-stat">
                <div class="stat-number">{{ auth()->user()->bookings()->count() }}</div>
                <div class="stat-label">Total Pemesanan</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <p class="text-muted mb-2">Belum membuat pemesanan?</p>
                    <a href="{{ route('courts.index') }}" class="btn btn-primary">Cari Lapangan</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h3 class="fw-bold mb-3">Pemesanan Terbaru</h3>

            @if($bookings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Lapangan</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td>
                                        <strong>{{ $booking->court->name }}</strong><br>
                                        <small class="text-muted">{{ $booking->court->location }}</small>
                                    </td>
                                    <td>{{ $booking->booking_date->format('d M Y') }}</td>
                                    <td>{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</td>
                                    <td><strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></td>
                                    <td>
                                        <span class="badge-status badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-info">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">Tidak ada pemesanan</p>
            @endif
        </div>
    </div>
</div>
@endsection
