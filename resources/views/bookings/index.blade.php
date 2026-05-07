@extends('layouts.app')

@section('title', 'Pemesanan Saya')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4">Pemesanan Saya</h1>

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
                                <span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-info">Detail</a>
                                @if($booking->status === 'pending')
                                    <a href="{{ route('payments.process', $booking->id) }}" class="btn btn-sm btn-success">Bayar</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $bookings->links() }}
    @else
        <div class="alert alert-info text-center">
            <p class="mb-0">Anda belum memiliki pemesanan. <a href="{{ route('courts.index') }}">Buat pemesanan sekarang</a></p>
        </div>
    @endif
</div>
@endsection
