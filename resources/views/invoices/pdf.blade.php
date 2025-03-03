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
            padding: 0 20px;
            color: #333;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #007BFF;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            color: #007BFF;
        }

        .header p {
            margin: 5px 0;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #007BFF;
            margin-bottom: 5px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 5px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
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
            padding: 3px 8px;
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
            margin-top: 20px;
            font-size: 13px;
            color: #555;
        }

        .footer strong {
            color: #007BFF;
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <h2>HAKA RENTAL MOBIL</h2>
            <p>Telp: +62 822 535 456 | Email: hakarentcar@gmail.com</p>
        </div>

        <!-- Informasi Pelanggan -->
        <p class="section-title">Informasi Pelanggan</p>
        <table class="info-table">
            <tr>
                <td style="width: 150px; vertical-align: top;"><strong>Nama:</strong></td>
                <td>{{ $invoice->rental->customer->name }}</td>
            </tr>
            <tr>
                <td style="width: 150px; vertical-align: top;"><strong>Email:</strong></td>
                <td>{{ $invoice->rental->customer->email }}</td>
            </tr>
            <tr>
                <td style="width: 150px; vertical-align: top;"><strong>Telepon:</strong></td>
                <td>{{ $invoice->rental->customer->phone_number }}</td>
            </tr>
            <tr>
                <td style="width: 150px; vertical-align: top;"><strong>Alamat:</strong></td>
                <td>{{ $invoice->rental->customer->address }}</td>
            </tr>
        </table>

        <!-- Informasi Invoice -->
        <p class="section-title">Informasi Invoice</p>
        <table class="info-table">
            <tr>
                <td style="width: 150px; vertical-align: top;"><strong>Invoice:</strong></td>
                <td>{{ $invoice->invoice_number }}</td>
            </tr>
            <tr>
                <td style="width: 150px; vertical-align: top;"><strong>Tanggal:</strong></td>
                <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y') }}</td>
            </tr>
        </table>
        
        <!-- Detail Penyewaan -->
        <p class="section-title">Detail Penyewaan</p>
        <table class="table">
            <tr>
                <th>Jenis Mobil</th>
                <th>Durasi</th>
                <th class="text-right">Harga Sewa (Rp)</th>
                <th class="text-right">Total (Rp)</th>
            </tr>
            <tr>
                <td>{{ $invoice->rental->mobil->merk }} - {{ $invoice->rental->mobil->type }}</td>
                <td>{{ $invoice->rental->duration }} {{ ucfirst($invoice->rental->rental_type) }}</td>
                <td class="text-right">Rp{{ number_format($invoice->rental->mobil->price, 2, ',', '.') }}</td>
                <td class="text-right">
                    Rp{{ number_format($invoice->rental->mobil->price * $invoice->rental->duration, 2, ',', '.') }}
                </td>
            </tr>
        </table>

        <!-- Layanan Tambahan -->
        @if ($invoice->rental->services->isNotEmpty())
            <p class="section-title">Layanan Tambahan</p>
            <table class="table">
                <tr>
                    <th>Nama Layanan</th>
                    <th class="text-right">Harga (Rp)</th>
                </tr>
                @foreach ($invoice->rental->services as $service)
                    <tr>
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
                <td>Total Harga (Sebelum PPN)</td>
                <td class="text-right">
                    Rp{{ number_format($invoice->rental->total_price - $invoice->rental->ppn, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td>PPN 11%</td>
                <td class="text-right">Rp{{ number_format($invoice->rental->ppn, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total (Termasuk PPN)</th>
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
    </div>

</body>

</html>
