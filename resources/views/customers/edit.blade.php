@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
<div class="container">
    <h1 class="my-4">Edit Customer</h1>

    <a href="{{ route('customers.index') }}" class="btn btn-secondary mb-3">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $customer->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ $customer->email }}" required>
                </div>

                <div class="mb-3">
                    <label for="phone_number" class="form-label">Telepon</label>
                    <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{ $customer->phone_number }}">
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea id="address" name="address" class="form-control">{{ $customer->address }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Update
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
