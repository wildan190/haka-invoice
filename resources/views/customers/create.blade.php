@extends('layouts.app')

@section('title', 'Tambah Customer')

@section('content')
<div class="container">
    <h1 class="my-4">Tambah Customer</h1>

    <a href="{{ route('customers.index') }}" class="btn btn-secondary mb-3">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="phone_number" class="form-label">Telepon</label>
                    <input type="text" id="phone_number" name="phone_number" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea id="address" name="address" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-save"></i> Simpan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
