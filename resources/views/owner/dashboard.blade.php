@extends('layouts.app')

@section('title', 'Owner Dashboard')

@section('content')
<div class="container-fluid py-4">
    <h1 class="fw-bold mb-4">Owner Dashboard</h1>

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="dashboard-stat">
                <div class="stat-number">{{ $courts->count() }}</div>
                <div class="stat-label">Lapangan Saya</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="dashboard-stat">
                <div class="stat-number">{{ $bookings->count() }}</div>
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
        <div class="col-12 mb-4">
            <a href="{{ route('owner.courts.create') }}" class="btn btn-success">Tambah Lapangan Baru</a>
            <a href="{{ route('owner.courts.index') }}" class="btn btn-outline-primary">Kelola Lapangan</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h3 class="fw-bold mb-3">Lapangan Saya</h3>
            @if($courts->count() > 0)
                <div class="row">
                    @foreach($courts as $court)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="{{ $court->image_url ?? 'https://via.placeholder.com/400x200' }}" class="card-img-top" alt="{{ $court->name }}" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $court->name }}</h5>
                                    <p class="card-text text-muted small">{{ $court->location }}</p>
                                    <p class="card-text"><strong>Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}/jam</strong></p>
                                    <a href="{{ route('owner.courts.show', $court->id) }}" class="btn btn-sm btn-primary">Kelola</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">Anda belum memiliki lapangan. <a href="{{ route('owner.courts.create') }}">Tambahkan lapangan</a></p>
            @endif
        </div>
    </div>
</div>
@endsection
