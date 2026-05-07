<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Booking Futsal') }} - @yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            :root {
                --primary-color: #007bff;
                --secondary-color: #6c757d;
                --success-color: #198754;
                --danger-color: #dc3545;
                --warning-color: #ffc107;
            }

            body {
                font-family: 'Figtree', sans-serif;
                background-color: #f8f9fa;
            }

            .navbar {
                background: linear-gradient(135deg, var(--primary-color) 0%, #0056b3 100%);
                box-shadow: 0 2px 4px rgba(0,0,0,.1);
            }

            .navbar-brand {
                font-weight: 600;
                font-size: 1.5rem;
            }

            .card {
                border: none;
                box-shadow: 0 2px 4px rgba(0,0,0,.1);
                transition: transform 0.3s, box-shadow 0.3s;
            }

            .card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0,0,0,.15);
            }

            .btn-primary {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
            }

            .btn-primary:hover {
                background-color: #0056b3;
                border-color: #0056b3;
            }

            .sidebar {
                background-color: #fff;
                border-right: 1px solid #dee2e6;
                min-height: calc(100vh - 76px);
            }

            .sidebar .nav-link {
                color: #495057;
                border-left: 3px solid transparent;
                padding: 0.75rem 1rem;
                transition: all 0.3s;
            }

            .sidebar .nav-link:hover {
                background-color: #f8f9fa;
                color: var(--primary-color);
            }

            .sidebar .nav-link.active {
                background-color: #e7f1ff;
                color: var(--primary-color);
                border-left-color: var(--primary-color);
                font-weight: 600;
            }

            .hero {
                background: linear-gradient(135deg, var(--primary-color) 0%, #0056b3 100%);
                color: white;
                padding: 80px 0;
                text-align: center;
            }

            .court-card {
                border-radius: 8px;
                overflow: hidden;
                transition: all 0.3s;
            }

            .court-card .court-image {
                height: 200px;
                background-color: #dee2e6;
                object-fit: cover;
            }

            .court-card:hover {
                box-shadow: 0 8px 16px rgba(0,0,0,.2);
            }

            .badge-status {
                display: inline-block;
                padding: 0.35rem 0.65rem;
                border-radius: 20px;
                font-size: 0.85rem;
                font-weight: 500;
            }

            .badge-pending {
                background-color: #fff3cd;
                color: #856404;
            }

            .badge-confirmed {
                background-color: #d1ecf1;
                color: #0c5460;
            }

            .badge-completed {
                background-color: #d4edda;
                color: #155724;
            }

            .badge-cancelled {
                background-color: #f8d7da;
                color: #721c24;
            }

            .time-slot {
                padding: 10px;
                margin: 5px;
                border: 1px solid #dee2e6;
                border-radius: 4px;
                cursor: pointer;
                transition: all 0.3s;
            }

            .time-slot:hover {
                background-color: #f8f9fa;
            }

            .time-slot.available {
                color: var(--success-color);
                border-color: var(--success-color);
            }

            .time-slot.booked {
                color: #999;
                cursor: not-allowed;
                background-color: #f5f5f5;
            }

            .time-slot.selected {
                background-color: var(--primary-color);
                color: white;
                border-color: var(--primary-color);
            }

            .dashboard-stat {
                background: white;
                border-radius: 8px;
                padding: 20px;
                text-align: center;
                box-shadow: 0 2px 4px rgba(0,0,0,.1);
            }

            .dashboard-stat .stat-number {
                font-size: 2rem;
                font-weight: 700;
                color: var(--primary-color);
            }

            .dashboard-stat .stat-label {
                color: #6c757d;
                font-size: 0.9rem;
                margin-top: 10px;
            }

            .alert {
                border: none;
                border-radius: 8px;
            }

            .form-control, .form-select {
                border-radius: 6px;
                border: 1px solid #dee2e6;
            }

            .form-control:focus, .form-select:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            }

            .footer {
                background-color: #343a40;
                color: white;
                padding: 30px 0;
                margin-top: 50px;
            }

            @media (max-width: 768px) {
                .sidebar {
                    display: none;
                }

                .hero {
                    padding: 40px 0;
                }
            }
        </style>
        @yield('extra-css')
    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-md navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('home') }}">
                    ⚽ Booking Futsal
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav ms-auto">
                        <a class="nav-link" href="{{ route('courts.index') }}">Lapangan</a>
                        @auth
                            <a class="nav-link" href="{{ route('bookings.index') }}">Pemesanan Saya</a>
                            @if(auth()->user()->isAdmin())
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Panel</a>
                            @elseif(auth()->user()->isOwner())
                                <a class="nav-link" href="{{ route('owner.dashboard') }}">Owner Panel</a>
                            @endif
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ auth()->user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                    <strong>Terjadi kesalahan!</strong>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="footer mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <h5>Booking Futsal</h5>
                        <p>Platform penyewaan lapangan futsal online yang mudah dan terpercaya.</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <h5>Hubungi Kami</h5>
                        <p>
                            Email: info@bookingfutsal.com<br>
                            Phone: +62-812-3456-7890<br>
                            Alamat: Jl. Contoh No. 123, Jakarta
                        </p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <h5>Jam Operasional</h5>
                        <p>
                            Senin - Jumat: 08:00 - 22:00<br>
                            Sabtu - Minggu: 07:00 - 23:00<br>
                            Buka Setiap Hari
                        </p>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <p>&copy; 2026 Booking Futsal. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        @yield('extra-js')
    </body>
</html>
