@extends('layouts.app')

@section('title', 'Beri Review')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Beri Review</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4 p-3 bg-light rounded">
                        <h6 class="fw-bold">{{ $booking->court->name }}</h6>
                        <p class="text-muted small mb-0">{{ $booking->booking_date->format('d F Y') }}</p>
                    </div>

                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                        <div class="mb-4">
                            <label for="rating" class="form-label fw-bold">Rating</label>
                            <div class="rating-input" style="font-size: 2rem;">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="star" data-value="{{ $i }}" style="cursor: pointer; color: #ddd;">★</span>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating" value="0" required>
                            @error('rating')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="comment" class="form-label fw-bold">Komentar (Opsional)</label>
                            <textarea name="comment" id="comment" class="form-control @error('comment') is-invalid @enderror" rows="5" placeholder="Bagikan pengalaman Anda...">{{ old('comment') }}</textarea>
                            @error('comment')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Kirim Review</button>
                            <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.star').forEach(star => {
    star.addEventListener('click', function() {
        const value = this.dataset.value;
        document.getElementById('rating').value = value;

        document.querySelectorAll('.star').forEach(s => {
            s.style.color = '#ddd';
        });

        for (let i = 0; i < value; i++) {
            document.querySelectorAll('.star')[i].style.color = '#ffc107';
        }
    });
});
</script>
@endsection
