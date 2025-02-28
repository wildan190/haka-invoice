@extends('layouts.app')

@section('title', 'Detail Customer')

@section('content')
<div class="container">
    <h1 class="my-4">Detail Customer</h1>

    <a href="{{ route('customers.index') }}" class="btn btn-secondary mb-3">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>

    <div class="card">
        <div class="card-body">
            <h5><strong>Nama:</strong> {{ $customer->name }}</h5>
            <p><strong>Email:</strong> {{ $customer->email }}</p>
            <p><strong>Telepon:</strong> {{ $customer->phone_number }}</p>
            <p><strong>Alamat:</strong> {{ $customer->address }}</p>

            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">
                <i class="fa-solid fa-pen"></i> Edit
            </a>

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
