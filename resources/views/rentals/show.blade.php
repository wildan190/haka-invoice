@extends('layouts.app')

@section('title', 'Detail Rental')

@section('content')
    <div class="container my-4">
        <h1 class="text-center mb-4">Detail Rental</h1>

        <a href="{{ route('rentals.index') }}" class="btn btn-secondary mb-3">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3"><strong>Customer:</strong> {{ $rental->customer->name }}</h5>
                <h5 class="mb-3"><strong>Mobil:</strong> {{ $rental->mobil->merk }} - {{ $rental->mobil->type }}</h5>
                <h5 class="mb-3"><strong>Durasi:</strong> {{ $rental->duration }} {{ $rental->rental_type }}</h5>
                <h5 class="mb-3"><strong>Total Harga:</strong> Rp{{ number_format($rental->total_price, 2, ',', '.') }}</h5>
            </div>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <h3 class="mb-3">Layanan Tambahan</h3>
                <ul class="list-group">
                    @foreach ($rental->services as $service)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $service->service_name }}
                            <span>Rp{{ number_format($service->service_price, 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
