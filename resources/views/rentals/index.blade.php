@extends('layouts.app')

@section('title', 'Daftar Rental')

@section('content')
    <div class="container">
        <h1 class="my-4">Daftar Rental</h1>

        <a href="{{ route('rentals.create') }}" class="btn btn-primary mb-3">
            <i class="fa-solid fa-plus"></i> Tambah Rental
        </a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($rentals->isEmpty())
            <div class="alert alert-warning">Tidak ada data rental.</div>
        @else
            <!-- Tampilan Desktop (Tabel) -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Customer</th>
                            <th>Mobil</th>
                            <th>Durasi</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rentals as $rental)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $rental->customer->name }}</td>
                                <td>{{ $rental->mobil->merk }} - {{ $rental->mobil->type }}</td>
                                <td>{{ $rental->duration }} {{ $rental->rental_type }}</td>
                                <td>Rp{{ number_format($rental->total_price, 2, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $rental->status == 'lunas' ? 'success' : 'warning' }}">
                                        {{ ucfirst($rental->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('rentals.show', $rental->id) }}" class="btn btn-info btn-sm">
                                        <i class="fa-solid fa-eye"></i> Lihat
                                    </a>
                                    <a href="{{ route('rentals.edit', $rental->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </a>
                                    <form action="{{ route('rentals.destroy', $rental->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus rental ini?')">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                    @if ($rental->status == 'belum_lunas')
                                        <form action="{{ route('rentals.pay', $rental->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fa-solid fa-money-bill-wave"></i> Lunasi
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tampilan Mobile (Card with Collapse) -->
            <div class="d-md-none">
                @foreach ($rentals as $rental)
                    <div class="card mb-2 shadow-sm border-0 rounded-3">
                        <div class="card-body">
                            <!-- Nama Customer sebagai trigger collapse -->
                            <h5 class="card-title mb-0">
                                <a class="text-decoration-none d-block fw-bold text-dark" data-bs-toggle="collapse"
                                    href="#rental-{{ $rental->id }}" role="button">
                                    {{ $rental->customer->name }} <i class="fa-solid fa-chevron-down float-end"></i>
                                </a>
                            </h5>

                            <!-- Detail rental yang tersembunyi -->
                            <div class="collapse mt-2" id="rental-{{ $rental->id }}">
                                <p class="card-text text-muted small">
                                    <i class="fa-solid fa-car"></i> Mobil: {{ $rental->mobil->merk }} -
                                    {{ $rental->mobil->type }}<br>
                                    <i class="fa-solid fa-clock"></i> Durasi: {{ $rental->duration }}
                                    {{ $rental->rental_type }}<br>
                                    <i class="fa-solid fa-money-bill"></i> Total Harga:
                                    Rp{{ number_format($rental->total_price, 2, ',', '.') }}<br>
                                    <i class="fa-solid fa-check-circle"></i> Status:
                                    <span class="badge bg-{{ $rental->status == 'lunas' ? 'success' : 'warning' }}">
                                        {{ ucfirst($rental->status) }}
                                    </span>
                                </p>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('rentals.show', $rental->id) }}" class="btn btn-info btn-md w-100">
                                        <i class="fa-solid fa-eye"></i> Lihat
                                    </a>
                                    <a href="{{ route('rentals.edit', $rental->id) }}" class="btn btn-warning btn-md w-100">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </a>
                                    <form action="{{ route('rentals.destroy', $rental->id) }}" method="POST" class="d-grid">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-md w-100"
                                            onclick="return confirm('Hapus rental ini?')">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                    @if ($rental->status == 'belum_lunas')
                                        <form action="{{ route('rentals.pay', $rental->id) }}" method="POST" class="d-grid">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-md w-100">
                                                <i class="fa-solid fa-money-bill-wave"></i> Lunasi
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $rentals->links('vendor.pagination.bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
