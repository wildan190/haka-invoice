@extends('layouts.app')

@section('title', 'Tambah Rental')

@section('content')

    <div class="container">
        <h1 class="my-4 text-center">Tambah Rental</h1>

        <a href="{{ route('rentals.index') }}" class="btn btn-secondary mb-3">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('rentals.store') }}" method="POST">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

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
                        <div class="input-group">
                            <input type="text" id="mobil_nama"
                                class="form-control @error('mobil_id') is-invalid @enderror" placeholder="Pilih Mobil"
                                readonly required>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#modalListMobil">
                                Pilih Mobil
                            </button>
                        </div>
                        <input type="hidden" id="mobil_id" name="mobil_id" required>
                        @error('mobil_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Include Modal -->
                    @include('rentals.components.modal-list-mobil')

                    <div class="mb-3">
                        <label for="rental_type" class="form-label">Jenis Rental</label>
                        <select id="rental_type" name="rental_type"
                            class="form-control @error('rental_type') is-invalid @enderror" required>
                            <option value="hari" {{ old('rental_type') == 'hari' ? 'selected' : '' }}>Hari</option>
                            <option value="bulan" {{ old('rental_type') == 'bulan' ? 'selected' : '' }}>Bulan
                            </option>
                        </select>
                        @error('rental_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="duration" class="form-label">Durasi (Hari / Bulan)</label>
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
                        <small class="form-text text-muted">Jika tidak menggunakan DP, langsung bayar penuh.</small>
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
                            <div class="service-row mb-2 d-flex">
                                <input type="text" name="services[0][service_name]" placeholder="Nama Layanan"
                                    class="form-control me-2" />
                                <input type="number" name="services[0][service_price]" placeholder="Harga"
                                    class="form-control" />
                            </div>
                        </div>
                        <button type="button" id="add-service" class="btn btn-primary mt-2">Tambah Layanan</button>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
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
            newService.className = 'service-row mb-2 d-flex';
            newService.innerHTML = `
            <input type="text" name="services[${serviceIndex}][service_name]" placeholder="Nama Layanan" class="form-control me-2" />
            <input type="number" name="services[${serviceIndex}][service_price]" placeholder="Harga" class="form-control" />
        `;
            container.appendChild(newService);
            serviceIndex++;
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn-pilih-mobil');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const mobilId = this.getAttribute('data-id');
                    const mobilMerk = this.getAttribute('data-merk');
                    const mobilType = this.getAttribute('data-type');

                    document.getElementById('mobil_id').value = mobilId;
                    document.getElementById('mobil_nama').value = `${mobilMerk} - ${mobilType}`;
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const useDpSelect = document.querySelector('select[name="use_dp"]');
            const dpPaidInput = document.getElementById('dp_paid');
            const serviceContainer = document.getElementById('services-container');
            const mobilIdInput = document.getElementById('mobil_id');

            // Fungsi untuk menghitung total harga
            function calculateTotal() {
                let total = 0;

                // Ambil harga mobil dari atribut data
                const selectedMobil = document.querySelector(`.btn-pilih-mobil[data-id="${mobilIdInput.value}"] `);
                if (selectedMobil) {
                    const hargaMobil = parseFloat(selectedMobil.getAttribute('data-harga')) || 0;
                    total += hargaMobil;
                }

                // Ambil harga dari layanan tambahan
                const servicePrices = serviceContainer.querySelectorAll(
                    'input[name^="services"][name$="[service_price]"]');
                servicePrices.forEach(input => {
                    total += parseFloat(input.value) || 0;
                });

                return total;
            }

            // Event listener untuk perubahan di "Gunakan DP?"
            useDpSelect.addEventListener('change', function() {
                if (useDpSelect.value === "0") { // Jika "Tidak" menggunakan DP
                    const total = calculateTotal();
                    dpPaidInput.value = total; // Isi dp_paid dengan total harga
                    dpPaidInput.setAttribute('readonly', true); // Buat readonly
                } else {
                    dpPaidInput.value = ""; // Kosongkan jika "Ya"
                    dpPaidInput.removeAttribute('readonly'); // Hapus readonly
                }
            });

            // Event listener untuk perhitungan ulang harga jika ada perubahan layanan atau mobil
            serviceContainer.addEventListener('input', () => {
                if (useDpSelect.value === "0") {
                    dpPaidInput.value = calculateTotal(); // Update dp_paid jika "Tidak" menggunakan DP
                }
            });
        });
    </script>
    <style>
        .form-control {
            border-radius: 0.25rem;
        }

        .btn {
            border-radius: 0.25rem;
        }

        .card {
            border-radius: 0.5rem;
        }

        .service-row input {
            flex: 1;
        }

        .service-row input:first-child {
            margin-right: 0.5rem;
        }

        @media (max-width: 576px) {
            .service-row {
                flex-direction: column;
            }

            .service-row input {
                margin-bottom: 0.5rem;
            }

            .service-row input:first-child {
                margin-right: 0;
            }
        }
    </style>
@endsection
