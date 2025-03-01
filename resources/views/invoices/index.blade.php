@extends('layouts.app')

@section('title', 'Daftar Invoice')

@section('content')
    <div class="container">
        <h1 class="my-4">Daftar Invoice</h1>

        <a href="{{ route('invoices.create') }}" class="btn btn-primary mb-3">
            <i class="fa-solid fa-plus"></i> Buat Invoice
        </a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($invoices->isEmpty())
            <div class="alert alert-warning">Tidak ada data invoice.</div>
        @else
            <!-- Tampilan Desktop (Tabel) -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Nomor Invoice</th>
                            <th>Tanggal</th>
                            <th>Rental</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->invoice_date }}</td>
                                <td>{{ $invoice->rental->customer->name }} - {{ $invoice->rental->mobil->type }}</td>
                                <td>
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-info btn-sm">
                                        <i class="fa-solid fa-eye"></i> Lihat
                                    </a>
                                    <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </a>
                                    <a href="{{ route('invoices.pdf', $invoice->id) }}" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-file-pdf"></i> PDF
                                    </a>
                                    <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus invoice ini?')">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tampilan Mobile (Card with Collapse) -->
            <div class="d-md-none">
                @foreach ($invoices as $invoice)
                    <div class="card mb-2 shadow-sm border-0 rounded-3">
                        <div class="card-body">
                            <!-- Nomor Invoice sebagai trigger collapse -->
                            <h5 class="card-title mb-0">
                                <a class="text-decoration-none d-block fw-bold text-dark" data-bs-toggle="collapse"
                                    href="#invoice-{{ $invoice->id }}" role="button">
                                    Invoice: {{ $invoice->invoice_number }} <i
                                        class="fa-solid fa-chevron-down float-end"></i>
                                </a>
                            </h5>

                            <!-- Detail invoice yang tersembunyi -->
                            <div class="collapse mt-2" id="invoice-{{ $invoice->id }}">
                                <p class="card-text text-muted small">
                                    <i class="fa-solid fa-calendar"></i> Tanggal: {{ $invoice->invoice_date }}<br>
                                    <i class="fa-solid fa-user"></i> Rental: {{ $invoice->rental->customer->name }} -
                                    {{ $invoice->rental->mobil->merk }}
                                </p>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-info btn-md w-100">
                                        <i class="fa-solid fa-eye"></i> Lihat
                                    </a>
                                    <a href="{{ route('invoices.edit', $invoice->id) }}"
                                        class="btn btn-warning btn-md w-100">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </a>
                                    <a href="{{ route('invoices.pdf', $invoice->id) }}"
                                        class="btn btn-danger btn-md w-100">
                                        <i class="fa-solid fa-file-pdf"></i> PDF
                                    </a>
                                    <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST"
                                        class="d-grid">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-md w-100"
                                            onclick="return confirm('Hapus invoice ini?')">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $invoices->links('vendor.pagination.bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
