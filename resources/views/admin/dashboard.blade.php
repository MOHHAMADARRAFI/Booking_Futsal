@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid py-4">
    <h1 class="fw-bold mb-4">Admin Dashboard</h1>

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="dashboard-stat">
                <div class="stat-number">{{ $totalCourts }}</div>
                <div class="stat-label">Total Lapangan</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="dashboard-stat">
                <div class="stat-number">{{ $totalBookings }}</div>
                <div class="stat-label">Total Pemesanan</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="dashboard-stat">
                <div class="stat-number">{{ $pendingBookings }}</div>
                <div class="stat-label">Pemesanan Pending</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="dashboard-stat">
                <div class="stat-number">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="stat-label">Total Revenue</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Pemesanan Terbaru</h5>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Pelanggan</th>
                                    <th>Lapangan</th>
                                    <th>Tanggal</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBookings as $booking)
                                    <tr>
                                        <td>{{ $booking->user->name }}</td>
                                        <td>{{ $booking->court->name }}</td>
                                        <td>{{ $booking->booking_date->format('d M Y') }}</td>
                                        <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge-status badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-info">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Tidak ada pemesanan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
