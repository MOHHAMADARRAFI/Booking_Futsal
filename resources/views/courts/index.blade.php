@extends('layouts.app')

@section('title', 'Daftar Lapangan')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="fw-bold">Daftar Lapangan Futsal</h1>
            <p class="text-muted">Pilih lapangan favorit Anda dan lakukan booking sekarang</p>
        </div>
    </div>

    @if($courts->count() > 0)
        <div class="row">
            @foreach($courts as $court)
                <div class="col-md-4 mb-4">
                    <div class="card court-card h-100">
                        <img src="{{ $court->image_url ?? 'https://via.placeholder.com/400x200?text=Lapangan+' . $court->id }}" class="court-image card-img-top" alt="{{ $court->name }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $court->name }}</h5>
                            <p class="card-text text-muted small">{{ $court->location }}</p>
                            
                            <div class="mb-2">
                                <small class="text-muted">Kapasitas pemain:</small>
                                <span class="badge bg-info">{{ $court->capacity }} orang</span>
                            </div>

                            <div class="mb-3 mt-auto">
                                <p class="card-text">
                                    <strong class="text-primary" style="font-size: 1.3rem;">
                                        Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}<span style="font-size: 0.8rem;">/jam</span>
                                    </strong>
                                </p>
                            </div>

                            @if($court->description)
                                <p class="card-text small text-muted mb-3">{{ Str::limit($court->description, 80) }}</p>
                            @endif

                            <a href="{{ route('courts.show', $court->id) }}" class="btn btn-primary w-100">
                                Lihat Detail & Booking
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info text-center">
            <p class="mb-0">Tidak ada lapangan yang tersedia saat ini</p>
        </div>
    @endif
</div>
@endsection
