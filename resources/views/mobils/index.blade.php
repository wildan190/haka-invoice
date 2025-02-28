@extends('layouts.app')

@section('title', 'Daftar Mobil')

@section('content')
<div class="container">
    <h1 class="my-4">Daftar Mobil</h1>
    
    <a href="{{ route('mobils.create') }}" class="btn btn-primary mb-3">
        <i class="fa-solid fa-plus"></i> Tambah Mobil
    </a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tampilan Desktop (Tabel) -->
    <div class="table-responsive d-none d-md-block">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No.</th>
                    <th>Tipe</th>
                    <th>Merk</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mobils as $mobil)
                <tr>
                    <td>{{ ($mobils->currentPage() - 1) * $mobils->perPage() + $loop->iteration }}</td>
                    <td>{{ $mobil->type }}</td>
                    <td>{{ $mobil->merk }}</td>
                    <td>Rp {{ number_format($mobil->price, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($mobil->status) }}</td>
                    <td>
                        <a href="{{ route('mobils.show', $mobil->id) }}" class="btn btn-info btn-sm">
                            <i class="fa-solid fa-eye"></i> Lihat
                        </a>
                        <a href="{{ route('mobils.edit', $mobil->id) }}" class="btn btn-warning btn-sm">
                            <i class="fa-solid fa-pen"></i> Edit
                        </a>
                        <form action="{{ route('mobils.destroy', $mobil->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus mobil ini?')">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada mobil.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

<!-- Tampilan Mobile (Card with Collapse) -->
<div class="d-md-none">
    @forelse ($mobils as $mobil)
    <div class="card mb-2 shadow-sm border-0 rounded-3">
        <div class="card-body">
            <!-- Nama Mobil sebagai trigger collapse -->
            <h5 class="card-title mb-0">
                <a class="text-decoration-none d-block fw-bold text-dark" data-bs-toggle="collapse" href="#mobil-{{ $mobil->id }}" role="button">
                    {{ $mobil->type }} - {{ $mobil->merk }} <i class="fa-solid fa-chevron-down float-end"></i>
                </a>
            </h5>

            <!-- Detail mobil yang tersembunyi -->
            <div class="collapse mt-2" id="mobil-{{ $mobil->id }}">
                <p class="card-text text-muted small">
                    <i class="fa-solid fa-tag"></i> Harga: Rp {{ number_format($mobil->price, 0, ',', '.') }} <br>
                    <i class="fa-solid fa-car"></i> Status: {{ ucfirst($mobil->status) }}
                </p>
                <div class="d-grid gap-2">
                    <a href="{{ route('mobils.show', $mobil->id) }}" class="btn btn-info btn-md w-100">
                        <i class="fa-solid fa-eye"></i> Lihat
                    </a>
                    <a href="{{ route('mobils.edit', $mobil->id) }}" class="btn btn-warning btn-md w-100">
                        <i class="fa-solid fa-pen"></i> Edit
                    </a>
                    <form action="{{ route('mobils.destroy', $mobil->id) }}" method="POST" class="d-grid">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-md w-100" onclick="return confirm('Hapus mobil ini?')">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <p class="text-center text-muted">Tidak ada mobil.</p>
    @endforelse
</div>


    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $mobils->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>
@endsection
