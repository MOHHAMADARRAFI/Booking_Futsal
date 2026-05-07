@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<style>
    .reset-container {
        min-height: calc(100vh - 76px);
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        padding: 20px;
    }

    .reset-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 450px;
        padding: 40px;
    }

    .reset-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .reset-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
    }

    .reset-header p {
        color: #6c757d;
        font-size: 14px;
        line-height: 1.5;
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

    .btn-submit {
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

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(0, 123, 255, 0.3);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .back-link {
        text-align: center;
        margin-top: 24px;
        padding-top: 24px;
        border-top: 1px solid #e0e0e0;
    }

    .back-link a {
        color: #007bff;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
    }

    .back-link a:hover {
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

    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }

    .alert button.btn-close {
        padding: 0;
        width: 20px;
        height: 20px;
    }

    @media (max-width: 576px) {
        .reset-card {
            padding: 30px 20px;
        }

        .reset-header h1 {
            font-size: 24px;
        }
    }
</style>

<div class="reset-container">
    <div class="reset-card">
        <!-- Header -->
        <div class="reset-header">
            <h1>⚽ Booking Futsal</h1>
            <p>Lupa Password?</p>
            <p style="font-size: 13px; margin-top: 10px;">Masukkan email Anda dan kami akan mengirim link untuk reset password</p>
        </div>

        <!-- Success Message -->
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong>
                <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Reset Form -->
        <form action="{{ route('password.email') }}" method="POST" novalidate>
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

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">
                Kirim Link Reset Password
            </button>
        </form>

        <!-- Back Link -->
        <div class="back-link">
            <a href="{{ route('login') }}">← Kembali ke login</a>
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
</script>
@endsection
