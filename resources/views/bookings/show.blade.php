@extends('layouts.app')

@section('title', 'Detail Pemesanan')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Pemesanan #{{ $booking->id }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Lapangan</small>
                            <h6 class="fw-bold">{{ $booking->court->name }}</h6>
                            <small class="text-muted">{{ $booking->court->location }}</small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Status</small>
                            <span class="badge-status badge-{{ $booking->status }} d-inline-block">{{ ucfirst($booking->status) }}</span>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Tanggal Booking</small>
                            <h6 class="fw-bold">{{ $booking->booking_date->format('d F Y') }}</h6>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Waktu</small>
                            <h6 class="fw-bold">{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</h6>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Harga Per Jam</small>
                            <h6 class="fw-bold">Rp {{ number_format($booking->court->price_per_hour, 0, ',', '.') }}</h6>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Total Harga</small>
                            <h6 class="fw-bold text-primary">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</h6>
                        </div>
                    </div>

                    @if($booking->notes)
                        <hr>
                        <div>
                            <small class="text-muted d-block">Catatan</small>
                            <p class="mb-0">{{ $booking->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            @if($booking->payment)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <small class="text-muted d-block">Metode Pembayaran</small>
                                <h6 class="fw-bold">{{ ucfirst(str_replace('_', ' ', $booking->payment->payment_method)) }}</h6>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Status Pembayaran</small>
                                <span class="badge-status badge-{{ $booking->payment->status }}">{{ ucfirst($booking->payment->status) }}</span>
                            </div>
                        </div>

                        @if($booking->payment->transaction_id)
                            <small class="text-muted d-block">ID Transaksi</small>
                            <code>{{ $booking->payment->transaction_id }}</code>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Aksi</h6>

                    @if($booking->status === 'pending')
                        <a href="{{ route('payments.process', $booking->id) }}" class="btn btn-success btn-sm w-100 mb-2">
                            💰 Lakukan Pembayaran
                        </a>
                        <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-primary btn-sm w-100 mb-2">
                            ✏️ Edit Pemesanan
                        </a>
                        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan booking ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                ❌ Batalkan Booking
                            </button>
                        </form>
                    @elseif($booking->status === 'completed' && !$booking->review)
                        <a href="{{ route('reviews.create', $booking->id) }}" class="btn btn-primary btn-sm w-100">
                            ⭐ Beri Review
                        </a>
                    @elseif($booking->status === 'completed' && $booking->review)
                        <div class="alert alert-info alert-sm mb-0">
                            <small>✅ Anda sudah memberikan review untuk booking ini</small>
                        </div>
                    @endif

                    <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary btn-sm w-100 mt-3">
                        ← Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
