@extends('layouts.app')

@section('title', 'Tambah Rental')

@section('content')
    <div class="container">
        <h1 class="my-4">Tambah Rental</h1>

        <a href="{{ route('rentals.index') }}" class="btn btn-secondary mb-3">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('rentals.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="customer_id" class="form-label">Customer</label>
                        <select id="customer_id" name="customer_id"
                            class="form-control @error('customer_id') is-invalid @enderror" required>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mobil_id" class="form-label">Mobil</label>
                        <select id="mobil_id" name="mobil_id" class="form-control @error('mobil_id') is-invalid @enderror"
                            required>
                            @foreach ($mobils as $mobil)
                                <option value="{{ $mobil->id }}" {{ old('mobil_id') == $mobil->id ? 'selected' : '' }}>
                                    {{ $mobil->merk }} - {{ $mobil->type }}
                                </option>
                            @endforeach
                        </select>
                        @error('mobil_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="rental_type" class="form-label">Jenis Rental</label>
                        <select id="rental_type" name="rental_type"
                            class="form-control @error('rental_type') is-invalid @enderror" required>
                            <option value="hari" {{ old('rental_type') == 'hari' ? 'selected' : '' }}>Hari</option>
                            <option disabled value="bulan" {{ old('rental_type') == 'bulan' ? 'selected' : '' }}>Bulan
                            </option>
                        </select>
                        @error('rental_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="duration" class="form-label">Durasi (Hari)</label>
                        <input type="number" id="duration" name="duration"
                            class="form-control @error('duration') is-invalid @enderror" value="{{ old('duration') }}"
                            required>
                        @error('duration')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gunakan DP?</label>
                        <select name="use_dp" class="form-control @error('use_dp') is-invalid @enderror" required>
                            <option value="1" {{ old('use_dp') == '1' ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ old('use_dp') == '0' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error('use_dp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="dp_paid" class="form-label">Jumlah DP (Opsional)</label>
                        <input type="number" id="dp_paid" name="dp_paid"
                            class="form-control @error('dp_paid') is-invalid @enderror" value="{{ old('dp_paid') }}">
                        @error('dp_paid')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gunakan PPN?</label>
                        <select name="use_ppn" class="form-control @error('use_ppn') is-invalid @enderror" required>
                            <option value="1" {{ old('use_ppn') == '1' ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ old('use_ppn') == '0' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error('use_ppn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Layanan Tambahan</label>
                        <div id="services-container">
                            <div class="service-row mb-2">
                                <input type="text" name="services[0][service_name]" placeholder="Nama Layanan"
                                    class="form-control d-inline-block w-45" />
                                <input type="number" name="services[0][service_price]" placeholder="Harga"
                                    class="form-control d-inline-block w-45 ml-2" />
                            </div>
                        </div>
                        <button type="button" id="add-service" class="btn btn-primary mt-2">Tambah Layanan</button>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-save"></i> Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let serviceIndex = 1;
        document.getElementById('add-service').addEventListener('click', () => {
            const container = document.getElementById('services-container');
            const newService = document.createElement('div');
            newService.className = 'service-row mb-2';
            newService.innerHTML = `
            <input type="text" name="services[${serviceIndex}][service_name]" placeholder="Nama Layanan" class="form-control d-inline-block w-45" />
            <input type="number" name="services[${serviceIndex}][service_price]" placeholder="Harga" class="form-control d-inline-block w-45 ml-2" />
        `;
            container.appendChild(newService);
            serviceIndex++;
        });
    </script>

@endsection
