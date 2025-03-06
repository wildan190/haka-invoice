@extends('layouts.app')

@section('title', 'Detail Invoice')

@section('content')
    <div class="container">
        <h1 class="my-4 text-center text-primary">Detail Invoice</h1>

        <a href="{{ route('invoices.index') }}" class="btn btn-secondary mb-3">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>

        <div class="card shadow-lg border-0">
            <div class="card-body bg-light">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Nomor Invoice:</strong> <span class="text-info">{{ $invoice->invoice_number }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Tanggal:</strong> <span class="text-info">{{ $invoice->invoice_date }}</span></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Customer:</strong> <span class="text-info">{{ $invoice->rental->customer->name }}</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Mobil:</strong> <span class="text-info">{{ $invoice->rental->mobil->merk }} -
                                {{ $invoice->rental->mobil->type }}</span></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <p><strong>Total Harga:</strong> <span
                                class="text-success">Rp{{ number_format($invoice->rental->total_price, 2, ',', '.') }}</span>
                        </p>
                    </div>
                </div>
                <div class="text-center">
                    <a href="{{ route('invoices.pdf', $invoice->id) }}" class="btn btn-danger">
                        <i class="fa-solid fa-file-pdf"></i> Cetak PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
