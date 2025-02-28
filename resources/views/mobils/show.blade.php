@extends('layouts.app')

@section('title', 'Detail Mobil')

@section('content')
<div class="container">
    <h1 class="my-4">Detail Mobil</h1>

    <a href="{{ route('mobils.index') }}" class="btn btn-secondary mb-3">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $mobil->type }} - {{ $mobil->merk }}</h5>
            <p><strong>Harga:</strong> Rp {{ number_format($mobil->price, 0, ',', '.') }}</p>
            <p><strong>Status:</strong> {{ ucfirst($mobil->status) }}</p>
            <p><strong>Deskripsi:</strong> {{ $mobil->description }}</p>
        </div>
    </div>
</div>
@endsection
