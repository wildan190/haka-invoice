@extends('layouts.app')

@section('title', 'Detail Mobil')

@section('content')
    <div class="container">
        <h1 class="my-4 text-center">Detail Mobil</h1>

        <a href="{{ route('mobils.index') }}" class="btn btn-secondary mb-3">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>

        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">{{ $mobil->type }} - {{ $mobil->merk }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Harga:</strong> <span class="text-success">Rp
                                {{ number_format($mobil->price, 0, ',', '.') }}</span></p>
                        <p><strong>Status:</strong> <span class="badge badge-info">{{ ucfirst($mobil->status) }}</span></p>
                        <p><strong>Nomor Plat:</strong> {{ $mobil->number_plate }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Deskripsi:</strong></p>
                        <p>{{ $mobil->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
