@extends('layouts.app')

@section('title', 'Buat Pemesanan Baru')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Buat Pemesanan Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="court_id" class="form-label fw-bold">Pilih Lapangan</label>
                            <select name="court_id" id="court_id" class="form-select @error('court_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Lapangan --</option>
                                @foreach($courts as $court)
                                    <option value="{{ $court->id }}" @if(old('court_id') == $court->id) selected @endif>
                                        {{ $court->name }} - Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}/jam
                                    </option>
                                @endforeach
                            </select>
                            @error('court_id')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="booking_date" class="form-label fw-bold">Tanggal Booking</label>
                            <input type="date" name="booking_date" id="booking_date" class="form-control @error('booking_date') is-invalid @enderror" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('booking_date') }}">
                            @error('booking_date')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_time" class="form-label fw-bold">Waktu Mulai</label>
                                    <input type="time" name="start_time" id="start_time" class="form-control @error('start_time') is-invalid @enderror" required value="{{ old('start_time') }}">
                                    @error('start_time')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_time" class="form-label fw-bold">Waktu Selesai</label>
                                    <input type="time" name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror" required value="{{ old('end_time') }}">
                                    @error('end_time')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <small><strong>Estimasi Harga:</strong> <span id="total-price">Rp 0</span></small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Lanjutkan ke Pembayaran</button>
                            <a href="{{ route('courts.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('court_id').addEventListener('change', updatePrice);
document.getElementById('start_time').addEventListener('change', updatePrice);
document.getElementById('end_time').addEventListener('change', updatePrice);

function updatePrice() {
    const courtId = document.getElementById('court_id').value;
    const startTime = document.getElementById('start_time').value;
    const endTime = document.getElementById('end_time').value;

    if (courtId && startTime && endTime) {
        const start = new Date('2000-01-01 ' + startTime);
        const end = new Date('2000-01-01 ' + endTime);
        const hours = (end - start) / (1000 * 60 * 60);

        // Get court price (simplified - you should fetch from server)
        const courtOption = document.querySelector(`#court_id option[value="${courtId}"]`);
        const priceText = courtOption.textContent;
        const priceMatch = priceText.match(/Rp ([\d.]+)/);
        
        if (priceMatch && hours > 0) {
            const price = parseInt(priceMatch[1].replace(/\./g, ''));
            const total = price * hours;
            document.getElementById('total-price').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
    }
}
</script>
@endsection
