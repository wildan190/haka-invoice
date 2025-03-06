@extends('layouts.app')

@section('title', 'Edit Mobil')

@section('content')
<div class="container">
    <h1 class="my-4">Edit Mobil</h1>

    <a href="{{ route('mobils.index') }}" class="btn btn-secondary mb-3">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('mobils.update', $mobil->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                  <label for="plate" class="form-label">Nomor Plat</label>
                  <input type="text" id="plate" name="number_plate" class="form-control" value="{{ old('number_plate', $mobil->number_plate) }}" placeholder="eg: B1234XYZ" required>
                  <small class="form-text text-muted">Disarankan tidak ada spasi di kolom ini.</small>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Tipe</label>
                    <input type="text" id="type" name="type" class="form-control" value="{{ old('type', $mobil->type) }}" required>
                </div>

                <div class="mb-3">
                    <label for="merk" class="form-label">Merk</label>
                    <input type="text" id="merk" name="merk" class="form-control" value="{{ old('merk', $mobil->merk) }}" required>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $mobil->price) }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea id="description" name="description" class="form-control">{{ old('description', $mobil->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="tersedia" {{ old('status', $mobil->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="disewa" {{ old('status', $mobil->status) == 'disewa' ? 'selected' : '' }}>Disewa</option>
                        <option value="perawatan" {{ old('status', $mobil->status) == 'perawatan' ? 'selected' : '' }}>Perawatan</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Perbarui
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
