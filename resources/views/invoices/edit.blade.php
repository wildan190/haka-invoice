@extends('layouts.app')

@section('title', 'Edit Invoice')

@section('content')
<div class="container">
    <h1 class="my-4">Edit Invoice</h1>

    <a href="{{ route('invoices.index') }}" class="btn btn-secondary mb-3">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="invoice_date" class="form-label">Tanggal Invoice</label>
                    <input type="date" id="invoice_date" name="invoice_date" class="form-control" value="{{ $invoice->invoice_date }}" required>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-save"></i> Update
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
