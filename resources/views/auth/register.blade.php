@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
<style>
    .register-container {
        min-height: calc(100vh - 76px);
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        padding: 20px;
    }

    .register-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 500px;
        padding: 40px;
    }

    .register-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .register-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
    }

    .register-header p {
        color: #6c757d;
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 20px;
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
        margin: 16px 0;
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

    .role-selector {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 20px;
    }

    .role-option {
        position: relative;
    }

    .role-option input[type="radio"] {
        display: none;
    }

    .role-option label {
        display: block;
        padding: 16px;
        border: 2px solid #e0e0e0;
        border-radius: 6px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        user-select: none;
    }

    .role-option input[type="radio"]:checked + label {
        border-color: #007bff;
        background-color: #f0f7ff;
        color: #007bff;
        font-weight: 600;
    }

    .role-option label:hover {
        border-color: #007bff;
    }

    .btn-register {
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

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(0, 123, 255, 0.3);
    }

    .btn-register:active {
        transform: translateY(0);
    }

    .login-link {
        text-align: center;
        margin-top: 24px;
        padding-top: 24px;
        border-top: 1px solid #e0e0e0;
    }

    .login-link p {
        color: #6c757d;
        font-size: 14px;
        margin: 0;
    }

    .login-link a {
        color: #007bff;
        text-decoration: none;
        font-weight: 600;
    }

    .login-link a:hover {
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

    .alert button.btn-close {
        padding: 0;
        width: 20px;
        height: 20px;
    }

    .password-requirements {
        background-color: #f8f9fa;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        padding: 12px 16px;
        margin-top: 12px;
        font-size: 12px;
        color: #6c757d;
    }

    .password-requirements li {
        margin: 4px 0;
    }

    @media (max-width: 576px) {
        .register-card {
            padding: 30px 20px;
        }

        .register-header h1 {
            font-size: 24px;
        }

        .role-selector {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="register-container">
    <div class="register-card">
        <!-- Header -->
        <div class="register-header">
            <h1>⚽ Booking Futsal</h1>
            <p>Buat akun untuk memulai</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal Daftar!</strong>
                <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Register Form -->
        <form action="{{ route('register') }}" method="POST" novalidate>
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama lengkap"
                    required
                    autofocus
                >
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

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
                >
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Phone -->
            <div class="form-group">
                <label for="phone" class="form-label">Nomor Telepon</label>
                <input
                    type="tel"
                    class="form-control @error('phone') is-invalid @enderror"
                    id="phone"
                    name="phone"
                    value="{{ old('phone') }}"
                    placeholder="08xxxxxxxxxx"
                    required
                >
                @error('phone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Address -->
            <div class="form-group">
                <label for="address" class="form-label">Alamat</label>
                <textarea
                    class="form-control @error('address') is-invalid @enderror"
                    id="address"
                    name="address"
                    placeholder="Masukkan alamat lengkap"
                    rows="3"
                    required
                >{{ old('address') }}</textarea>
                @error('address')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Role Selection -->
            <label class="form-label">Tipe Akun</label>
            <div class="role-selector">
                <div class="role-option">
                    <input
                        type="radio"
                        id="role_customer"
                        name="role"
                        value="customer"
                        {{ old('role', 'customer') === 'customer' ? 'checked' : '' }}
                        required
                    >
                    <label for="role_customer">
                        👤 Pelanggan
                    </label>
                </div>
                <div class="role-option">
                    <input
                        type="radio"
                        id="role_owner"
                        name="role"
                        value="owner"
                        {{ old('role') === 'owner' ? 'checked' : '' }}
                        required
                    >
                    <label for="role_owner">
                        🏢 Pemilik Lapangan
                    </label>
                </div>
            </div>
            @error('role')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    id="password"
                    name="password"
                    placeholder="Buat password yang kuat"
                    required
                >
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <div class="password-requirements">
                    <strong>Syarat Password:</strong>
                    <ul>
                        <li>Minimal 8 karakter</li>
                        <li>Mengandung huruf besar dan kecil</li>
                        <li>Mengandung angka</li>
                    </ul>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input
                    type="password"
                    class="form-control @error('password_confirmation') is-invalid @enderror"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Ulangi password"
                    required
                >
                @error('password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Terms -->
            <div class="form-check">
                <input
                    class="form-check-input @error('terms') is-invalid @enderror"
                    type="checkbox"
                    id="terms"
                    name="terms"
                    {{ old('terms') ? 'checked' : '' }}
                    required
                >
                <label class="form-check-label" for="terms">
                    Saya setuju dengan <a href="#" style="color: #007bff; text-decoration: none;">Syarat & Ketentuan</a>
                </label>
                @error('terms')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Register Button -->
            <button type="submit" class="btn-register">
                Daftar
            </button>
        </form>

        <!-- Login Link -->
        <div class="login-link">
            <p>
                Sudah punya akun?
                <a href="{{ route('login') }}">Masuk di sini</a>
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
