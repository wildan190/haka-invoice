@extends('layouts.app')

@section('title', 'Detail Rental')

@section('content')
    <div class="container">
        <h1 class="my-4">Detail Rental</h1>

        <a href="{{ route('rentals.index') }}" class="btn btn-secondary mb-3">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>

        <div class="card">
            <div class="card-body">
                <h5><strong>Customer:</strong> {{ $rental->customer->name }}</h5>
                <h5><strong>Mobil:</strong> {{ $rental->mobil->merk }} - {{ $rental->mobil->type }}</h5>
                <h5><strong>Durasi:</strong> {{ $rental->duration }} {{ $rental->rental_type }}</h5>
                <h5><strong>Total Harga:</strong> Rp{{ number_format($rental->total_price, 2, ',', '.') }}</h5>
            </div>
            <h3>Layanan Tambahan</h3>
            <ul>
                @foreach ($rental->services as $service)
                    <li>{{ $service->service_name }} - Rp{{ number_format($service->service_price, 0, ',', '.') }}</li>
                @endforeach
            </ul>

        </div>
    </div>
@endsection
