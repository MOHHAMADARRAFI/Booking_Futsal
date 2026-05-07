@extends('layouts.app')

@section('title', 'Proses Pembayaran')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Proses Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4 p-3 bg-light rounded">
                        <h6 class="fw-bold">Ringkasan Pemesanan</h6>
                        <div class="row mt-2">
                            <div class="col-6">
                                <small class="text-muted">Lapangan</small>
                                <p class="mb-2"><strong>{{ $booking->court->name }}</strong></p>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Tanggal & Waktu</small>
                                <p class="mb-2">
                                    <strong>{{ $booking->booking_date->format('d M Y') }}<br>
                                    {{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</strong>
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-6">
                                <small class="text-muted">Harga Per Jam</small>
                                <p class="mb-0">Rp {{ number_format($booking->court->price_per_hour, 0, ',', '.') }}</p>
                            </div>
                            <div class="col-6 text-end">
                                <h5 class="text-primary fw-bold mb-0">
                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                </h5>
                                <small class="text-muted">Total</small>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('payments.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                        <div class="mb-4">
                            <label class="form-label fw-bold">Pilih Metode Pembayaran</label>
                            
                            <div class="payment-methods">
                                <div class="form-check payment-method mb-2">
                                    <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash" required>
                                    <label class="form-check-label w-100" for="cash">
                                        💵 Tunai (Cash)
                                        <small class="text-muted d-block">Bayar langsung di lokasi</small>
                                    </label>
                                </div>

                                <div class="form-check payment-method mb-2">
                                    <input class="form-check-input" type="radio" name="payment_method" id="card" value="card" required>
                                    <label class="form-check-label w-100" for="card">
                                        💳 Kartu Kredit
                                        <small class="text-muted d-block">Visa, Mastercard, atau sejenisnya</small>
                                    </label>
                                </div>

                                <div class="form-check payment-method mb-2">
                                    <input class="form-check-input" type="radio" name="payment_method" id="transfer" value="bank_transfer" required>
                                    <label class="form-check-label w-100" for="transfer">
                                        🏦 Transfer Bank
                                        <small class="text-muted d-block">Transfer ke rekening kami</small>
                                    </label>
                                </div>

                                <div class="form-check payment-method mb-2">
                                    <input class="form-check-input" type="radio" name="payment_method" id="ewallet" value="e_wallet" required>
                                    <label class="form-check-label w-100" for="ewallet">
                                        📱 E-Wallet
                                        <small class="text-muted d-block">GCash, Dana, atau OVO</small>
                                    </label>
                                </div>
                            </div>

                            @error('payment_method')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="alert alert-info mb-4">
                            <small>
                                <strong>⚠️ Perhatian:</strong> Pastikan informasi pembayaran Anda benar sebelum melanjutkan. Pembayaran akan diproses setelah Anda mengklik tombol "Bayar Sekarang".
                            </small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                ✅ Bayar Sekarang - Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </button>
                            <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-outline-secondary">
                                ← Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Informasi Pembayaran</h6>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Untuk Transfer Bank</h6>
                    <p class="mb-2">
                        <strong>Bank:</strong> BCA<br>
                        <strong>Nomor Rekening:</strong> 1234567890<br>
                        <strong>Atas Nama:</strong> PT Booking Futsal Indonesia
                    </p>

                    <h6 class="fw-bold mb-3 mt-4">Untuk E-Wallet</h6>
                    <p class="mb-0">
                        <strong>GCash/Dana:</strong> +62 812-3456-7890
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.payment-method {
    padding: 12px;
    border: 2px solid #dee2e6;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s;
}

.payment-method:hover {
    border-color: #007bff;
    background-color: #f0f6ff;
}

.payment-method input:checked ~ .form-check-label {
    color: #007bff;
}

.form-check-input:checked ~ .form-check-label {
    font-weight: 500;
}
</style>
@endsection
