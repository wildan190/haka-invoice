@extends('layouts.app')

@section('title', 'Detail Rental')

@section('content')
    <div class="container my-5">
        <div class="text-center mb-5">
            <h1 class="display-4">Detail Rental</h1>
            <a href="{{ route('rentals.index') }}" class="btn btn-outline-secondary mt-3">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card shadow-sm mb-5">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Informasi Rental</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5><strong>Customer:</strong> {{ $rental->customer->name }}</h5>
                    </div>
                    <div class="col-md-6">
                        <h5><strong>Mobil:</strong> {{ $rental->mobil->merk }} - {{ $rental->mobil->type }}</h5>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5><strong>Durasi:</strong> {{ $rental->duration }} {{ $rental->rental_type }}</h5>
                    </div>
                    <div class="col-md-6">
                        <h5><strong>Total Harga:</strong> Rp{{ number_format($rental->total_price, 2, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-5">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Layanan Tambahan</h4>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach ($rental->services as $service)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $service->service_name }}
                            <span>Rp{{ number_format($service->service_price, 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('rentals.receipt', $rental->id) }}" class="btn btn-danger btn-lg" target="_blank">
                <i class="fa-solid fa-file-pdf"></i> Cetak Kwitansi
            </a>
        </div>
    </div>
@endsection
