<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            color: #333;
            font-size: 14px;
            background-color: #f8f9fa;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007BFF;
            padding-bottom: 10px;
        }

        .logo img {
            max-width: 100px;
        }

        .company-info {
            text-align: right;
        }

        .company-info h2 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
            color: #007BFF;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #007BFF;
            border-bottom: 2px solid #007BFF;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .table th {
            background: #007BFF;
            color: #fff;
        }

        .text-right {
            text-align: right;
        }

        .status {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .status-lunas {
            background-color: #28a745;
            color: #fff;
        }

        .status-belum-lunas {
            background-color: #dc3545;
            color: #fff;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 13px;
            color: #555;
        }

        .footer strong {
            color: #007BFF;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="header">
        <div class="logo">
            {{-- <img src="{{ public_path('assets/img/emblem.png') }}" alt="HAKA RENTAL MOBIL"> --}}
        </div>

        <div class="company-info">
            <h2>HAKA RENTAL <span style="color: #333;">MOBIL</span></h2>
            <p>Telp: +62 822 535 456 | Email: hakarentcar@gmail.com</p>
        </div>
    </div>

    <!-- Invoice Info -->
    <p class="section-title">Invoice: {{ $invoice->invoice_number }}</p>
    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y') }}</p>

    <!-- Detail Penyewaan -->
    <p class="section-title">Detail Penyewaan</p>
    <table class="table">
        <tr>
            <th>No.</th>
            <th>Jenis Mobil</th>
            <th>Durasi Sewa</th>
            <th class="text-right">Harga Sewa per {{ ucfirst($invoice->rental->rental_type) }} (Rp)</th>
            <th class="text-right">Total Harga (Rp)</th>
        </tr>
        <tr>
            <td>1</td>
            <td>{{ $invoice->rental->mobil->merk }} - {{ $invoice->rental->mobil->type }}</td>
            <td>{{ $invoice->rental->duration }} {{ ucfirst($invoice->rental->rental_type) }}</td>
            <td class="text-right">Rp{{ number_format($invoice->rental->mobil->price, 2, ',', '.') }}</td>
            <td class="text-right">Rp{{ number_format($invoice->rental->mobil->price * $invoice->rental->duration, 2, ',', '.') }}</td>
        </tr>
    </table>

    <!-- Additional Services -->
    @if ($invoice->rental->services->isNotEmpty())
        <p class="section-title">Layanan Tambahan</p>
        <table class="table">
            <tr>
                <th>No.</th>
                <th>Nama Layanan</th>
                <th class="text-right">Harga (Rp)</th>
            </tr>
            @foreach ($invoice->rental->services as $index => $service)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $service->service_name }}</td>
                    <td class="text-right">Rp{{ number_format($service->service_price, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>
    @endif

    <!-- Rincian Pembayaran -->
    <p class="section-title">Rincian Pembayaran</p>
    <table class="table">
        <tr>
            <th>Deskripsi</th>
            <th class="text-right">Jumlah (Rp)</th>
        </tr>
        <tr>
            <td>Total Harga (Sebelum PPN)</td>
            <td class="text-right">Rp{{ number_format($invoice->rental->total_price - $invoice->rental->ppn, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td>PPN 11%</td>
            <td class="text-right">Rp{{ number_format($invoice->rental->ppn, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Total Harga (Termasuk PPN)</th>
            <th class="text-right">Rp{{ number_format($invoice->rental->total_price, 2, ',', '.') }}</th>
        </tr>
        <tr>
            <td>DP Dibayar</td>
            <td class="text-right">Rp{{ number_format($invoice->rental->dp_paid, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Sisa Pembayaran</th>
            <th class="text-right">
                @if ($invoice->rental->status == 'lunas')
                    Rp0,00
                @else
                    Rp{{ number_format($invoice->rental->remaining_payment, 2, ',', '.') }}
                @endif
            </th>
        </tr>
    </table>

    <!-- Status Pembayaran -->
    <p><strong>Status Pembayaran:</strong>
        <span class="status {{ $invoice->rental->status == 'lunas' ? 'status-lunas' : 'status-belum-lunas' }}">
            {{ ucfirst($invoice->rental->status) }}
        </span>
    </p>

    <!-- Footer -->
    <p class="footer">
        <strong>Terima kasih telah menggunakan layanan HAKA RENTAL MOBIL</strong><br>
        Jika ada pertanyaan lebih lanjut, silakan hubungi kami.
    </p>

</body>
</html>
