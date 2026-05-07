@extends('layouts.app')

@section('title', 'Login')

@section('content')
<style>
    .login-container {
        min-height: calc(100vh - 76px);
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        padding: 20px;
    }

    .login-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 450px;
        padding: 40px;
    }

    .login-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .login-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
    }

    .login-header p {
        color: #6c757d;
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-control {
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        padding: 12px 16px;
        font-size: 14px;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .form-control.is-invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 12px;
        margin-top: 6px;
    }

    .form-check {
        margin-bottom: 20px;
    }

    .form-check-input {
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: #007bff;
        border-color: #007bff;
    }

    .form-check-label {
        color: #495057;
        font-size: 14px;
        cursor: pointer;
        margin-left: 8px;
        user-select: none;
    }

    .btn-login {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        font-weight: 600;
        border: none;
        border-radius: 6px;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 10px;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(0, 123, 255, 0.3);
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .divider {
        display: flex;
        align-items: center;
        margin: 30px 0;
        color: #999;
        font-size: 14px;
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background-color: #e0e0e0;
    }

    .divider span {
        padding: 0 10px;
    }

    .social-login {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 24px;
    }

    .social-btn {
        padding: 10px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        background: white;
        color: #495057;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .social-btn:hover {
        background-color: #f8f9fa;
        border-color: #007bff;
        color: #007bff;
    }

    .footer-links {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .footer-links a {
        color: #007bff;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .footer-links a:hover {
        color: #0056b3;
        text-decoration: underline;
    }

    .register-link {
        text-align: center;
        margin-top: 24px;
        padding-top: 24px;
        border-top: 1px solid #e0e0e0;
    }

    .register-link p {
        color: #6c757d;
        font-size: 14px;
        margin: 0;
    }

    .register-link a {
        color: #007bff;
        text-decoration: none;
        font-weight: 600;
    }

    .register-link a:hover {
        color: #0056b3;
        text-decoration: underline;
    }

    .alert {
        border-radius: 6px;
        border: none;
        margin-bottom: 20px;
        padding: 12px 16px;
        font-size: 14px;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }

    .alert-warning {
        background-color: #fff3cd;
        color: #856404;
    }

    .alert-info {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .alert button.btn-close {
        padding: 0;
        width: 20px;
        height: 20px;
    }

    /* Loading state */
    .btn-login:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .login-card {
            padding: 30px 20px;
        }

        .login-header h1 {
            font-size: 24px;
        }

        .social-login {
            grid-template-columns: 1fr;
        }

        .footer-links {
            flex-direction: column;
            gap: 8px;
        }

        .footer-links a {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="login-container">
    <div class="login-card">
        <!-- Header -->
        <div class="login-header">
            <h1>⚽ Booking Futsal</h1>
            <p>Masuk untuk melanjutkan</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal Login!</strong>
                <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST" novalidate>
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="nama@email.com"
                    required
                    autofocus
                >
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    id="password"
                    name="password"
                    placeholder="Masukkan password Anda"
                    required
                >
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="form-check">
                <input
                    class="form-check-input"
                    type="checkbox"
                    id="remember"
                    name="remember"
                    {{ old('remember') ? 'checked' : '' }}
                >
                <label class="form-check-label" for="remember">
                    Ingat saya di perangkat ini
                </label>
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn-login">
                Masuk
            </button>
        </form>

        <!-- Forgot Password & Register Links -->
        <div class="footer-links">
            <a href="{{ route('password.request') }}">Lupa Password?</a>
            {{-- <a href="{{ route('login') }}">Masuk dengan kode OTP</a> --}}
        </div>

        <!-- Divider -->
        <div class="divider">
            <span>atau</span>
        </div>

        <!-- Social Login (Optional) -->
        <div class="social-login">
            <a href="{{ route('login') }}" class="social-btn" title="Login dengan Google" style="opacity: 0.5; pointer-events: none;">
                🔷 Google
            </a>
            <a href="{{ route('login') }}" class="social-btn" title="Login dengan Facebook" style="opacity: 0.5; pointer-events: none;">
                🔷 Facebook
            </a>
        </div>

        <!-- Register Link -->
        <div class="register-link">
            <p>
                Belum punya akun?
                <a href="{{ route('register') }}">Daftar sekarang</a>
            </p>
        </div>

        <!-- Info for Different Roles -->
        <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid #e0e0e0; text-align: center; font-size: 12px; color: #999;">
            <p style="margin: 0;">
                Tamu: semua / Pemilik Lapangan: owner@example.com / Admin: admin@example.com
            </p>
        </div>
    </div>
</div>

<script>
    // Form validation
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            var forms = document.querySelectorAll('form[novalidate]');
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // Auto-focus first invalid field
    document.addEventListener('DOMContentLoaded', function () {
        const firstInvalid = document.querySelector('.form-control.is-invalid');
        if (firstInvalid) {
            firstInvalid.focus();
        }
    });
</script>
@endsection
