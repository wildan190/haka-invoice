@extends('layouts.app')

@section('title', 'Tambah Invoice')

@section('content')
    <div class="container">
        <h1 class="my-4">Tambah Invoice</h1>

        <a href="{{ route('invoices.index') }}" class="btn btn-secondary mb-3">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('invoices.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="rental_id" class="form-label">Rental</label>
                        <select id="rental_id" name="rental_id" class="form-control" required>
                            <option value="">Pilih Rental</option>
                            @foreach ($rentals as $rental)
                                <option value="{{ $rental->id }}">{{ $rental->customer->name }} -
                                    {{ $rental->mobil->type }}</option>
                            @endforeach
                        </select>
                        @error('rental_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="invoice_date" class="form-label">Tanggal Invoice</label>
                        <input type="date" id="invoice_date" name="invoice_date" class="form-control" required>
                        @error('invoice_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-save"></i> Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
