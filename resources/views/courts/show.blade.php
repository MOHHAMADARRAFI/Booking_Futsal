@extends('layouts.app')

@section('title', $court->name)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <img src="{{ $court->image_url ?? 'https://via.placeholder.com/600x400' }}" class="img-fluid rounded" alt="{{ $court->name }}" style="max-height: 400px; object-fit: cover; width: 100%;">
        </div>
        <div class="col-md-6">
            <h1 class="fw-bold mb-2">{{ $court->name }}</h1>
            <p class="text-muted mb-4">{{ $court->location }}</p>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted d-block">Harga Per Jam</small>
                            <h3 class="fw-bold text-primary">Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}</h3>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Kapasitas Pemain</small>
                            <h3 class="fw-bold">{{ $court->capacity }} Orang</h3>
                        </div>
                    </div>
                    <hr>
                    <p class="text-muted mb-0">Status: 
                        <span class="badge {{ $court->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($court->status) }}
                        </span>
                    </p>
                </div>
            </div>

            @auth
                <a href="{{ route('bookings.create') }}" class="btn btn-primary btn-lg w-100 mb-3">
                    Booking Lapangan Ini
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100 mb-3">
                    Login untuk Booking
                </a>
            @endauth

            @if(auth()->check() && auth()->user()->isOwner() && $court->owner_id === auth()->id())
                <div class="btn-group w-100" role="group">
                    <a href="{{ route('courts.edit', $court->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('courts.destroy', $court->id) }}" method="POST" class="w-100" onsubmit="return confirm('Yakin ingin menghapus lapangan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">Hapus</button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h3 class="fw-bold mb-4">Deskripsi</h3>
            <p class="lead">{{ $court->description ?? 'Tidak ada deskripsi' }}</p>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h3 class="fw-bold mb-4">Ulasan ({{ $reviews->total() }})</h3>
            
            @if($reviews->count() > 0)
                @foreach($reviews as $review)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="card-title mb-1">{{ $review->user->name }}</h6>
                                    <div class="mb-2">
                                        @for($i = 0; $i < 5; $i++)
                                            @if($i < $review->rating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-muted"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                            @if($review->comment)
                                <p class="card-text">{{ $review->comment }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach

                {{ $reviews->links() }}
            @else
                <p class="text-muted">Belum ada ulasan untuk lapangan ini</p>
            @endif
        </div>
    </div>
</div>
@endsection
