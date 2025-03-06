@extends('layouts.app')

@section('title', 'Detail Customer')

@section('content')
    <div class="container">
        <h1 class="my-4 text-center">Detail Customer</h1>

        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">
                <i class="fa-solid fa-pen"></i> Edit
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Informasi Customer</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5><strong>Nama:</strong></h5>
                        <p>{{ $customer->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5><strong>Email:</strong></h5>
                        <p>{{ $customer->email }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5><strong>Telepon:</strong></h5>
                        <p>{{ $customer->phone_number }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5><strong>Alamat:</strong></h5>
                        <p>{{ $customer->address }}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus customer ini?')">
                        <i class="fa-solid fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
