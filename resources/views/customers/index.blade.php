@extends('layouts.app')

@section('title', 'Daftar Customer')

@section('content')
    <div class="container">
        <h1 class="my-4">Daftar Customer</h1>

        <a href="{{ route('customers.create') }}" class="btn btn-primary mb-3">
            <i class="fa-solid fa-plus"></i> Tambah Customer
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
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                        <tr>
                            <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone_number }}</td>
                            <td>{{ $customer->address }}</td>
                            <td>
                                <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa-solid fa-eye"></i> Lihat
                                </a>
                                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm delete-button">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada customer.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tampilan Mobile (Card with Collapse) -->
        <div class="d-md-none">
            @forelse ($customers as $customer)
                <div class="card mb-2 shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <!-- Nama sebagai trigger collapse -->
                        <h5 class="card-title mb-0">
                            <a class="text-decoration-none d-block fw-bold text-dark" data-bs-toggle="collapse"
                                href="#customer-{{ $customer->id }}" role="button">
                                {{ $customer->name }} <i class="fa-solid fa-chevron-down float-end"></i>
                            </a>
                        </h5>

                        <!-- Detail customer yang tersembunyi -->
                        <div class="collapse mt-2" id="customer-{{ $customer->id }}">
                            <p class="card-text text-muted small">
                                <i class="fa-solid fa-envelope"></i> {{ $customer->email }} <br>
                                <i class="fa-solid fa-phone"></i> {{ $customer->phone_number }} <br>
                                <i class="fa-solid fa-map-marker-alt"></i> {{ $customer->address }}
                            </p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-info btn-md w-100">
                                    <i class="fa-solid fa-eye"></i> Lihat
                                </a>
                                <a href="{{ route('customers.edit', $customer->id) }}"
                                    class="btn btn-warning btn-md w-100">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-md w-100 delete-button">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">Tidak ada customer.</p>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $customers->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const form = button.closest('.delete-form');

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data yang dihapus tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yakin',
                        cancelButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

@endsection
