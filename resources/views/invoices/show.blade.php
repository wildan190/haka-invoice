@extends('layouts.app')

@section('title', 'Detail Invoice')

@section('content')
<div class="container">
    <h1 class="my-4">Detail Invoice</h1>

    <a href="{{ route('invoices.index') }}" class="btn btn-secondary mb-3">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>

    <div class="card">
        <div class="card-body">
            <p><strong>Nomor Invoice:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Tanggal:</strong> {{ $invoice->invoice_date }}</p>
            <p><strong>Customer:</strong> {{ $invoice->rental->customer->name }}</p>
            <p><strong>Mobil:</strong> {{ $invoice->rental->mobil->merk }} - {{ $invoice->rental->mobil->type }}</p>
            <p><strong>Total Harga:</strong> Rp{{ number_format($invoice->rental->total_price, 2, ',', '.') }}</p>
            <a href="{{ route('invoices.pdf', $invoice->id) }}" class="btn btn-danger">
                <i class="fa-solid fa-file-pdf"></i> Cetak PDF
            </a>
        </div>
    </div>
</div>
@endsection
