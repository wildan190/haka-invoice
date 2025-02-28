@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
        <div class="text-center mb-3">
            <h3 class="fw-bold">Login</h3>
            <p class="text-muted">Masuk ke akun Anda</p>
        </div>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>
                <a href="#" class="text-decoration-none text-dark">Lupa password?</a>
            </div>
            <button type="submit" class="btn btn-dark w-100">Login</button>
        </form>
        <div class="text-center mt-3">
            <p class="text-muted">Belum punya akun? <a href="{{ route('register') }}" class="fw-bold text-dark">Daftar</a></p>
        </div>
    </div>
</div>
@endsection
