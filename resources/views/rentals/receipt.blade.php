<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Rental - HAKA RENTAL</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            border: 2px solid #004aad;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            color: #004aad;
        }

        .header h2 {
            margin: 0;
            font-size: 28px;
        }

        .header h3 {
            margin: 5px 0;
            font-size: 18px;
            font-weight: normal;
        }

        .header p {
            margin: 2px 0;
            font-size: 12px;
            color: #333;
        }

        .line {
            border-top: 2px solid #004aad;
            margin: 20px 0;
        }

        .content {
            margin-bottom: 20px;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
        }

        .content th, .content td {
            padding: 8px 12px;
            vertical-align: top;
            border-bottom: 1px dashed #ccc;
        }

        .content th {
            text-align: left;
            color: #004aad;
            width: 30%;
        }

        .content td {
            text-align: left;
        }

        .amount {
            font-weight: bold;
            font-size: 18px;
            text-align: right;
            color: #d9534f;
        }

        .terbilang {
            font-style: italic;
            margin-top: -5px;
            font-size: 12px;
            text-align: right;
            color: #555;
        }

        .footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .signature {
            text-align: center;
        }

        .signature img {
            width: 150px;
            margin-bottom: -10px;
        }

        .signature p {
            margin: 0;
        }

        .signature .line-sign {
            width: 200px;
            border-top: 1px solid #555;
            margin: 5px auto;
        }

        .badge {
            display: inline-block;
            background-color: #004aad;
            color: #fff;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 12px;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="header">
        <h2>HAKA RENTAL</h2>
        <h3>KWITANSI PEMBAYARAN</h3>
        <p>Jl. Zafri Zam-Zam Komp. LLASDP 1 Blok A No. 5 Banjarmasin</p>
        <p>No. Telp: 0822 535 456</p>
        <div class="line"></div>
        <p>No. Kwitansi: <span class="badge">{{ $rental->id }}/{{ date('d/m/Y') }}</span></p>
        <p>Tanggal: {{ date('d-m-Y') }}</p>
    </div>

    <div class="content">
        <table>
            <tr>
                <th>Telah Terima Dari</th>
                <td>: {{ $rental->customer->name }}</td>
            </tr>
            <tr>
                <th>Uang Sejumlah</th>
                <td class="amount">Rp{{ number_format($rental->total_price, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="2" class="terbilang">
                    ({{ ucwords(Terbilang::make($rental->total_price)) }} Rupiah)
                </td>
            </tr>
            <tr>
                <th>Untuk Pembayaran</th>
                <td>: {{ $rental->mobil->merk }} - {{ $rental->mobil->type }} Durasi {{ $rental->duration }} {{ $rental->rental_type }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <div class="signature">
            <p>Penerima,</p>
            <div class="line-sign"></div>
        </div>
        <div class="signature">
            <p>Hormat Kami,</p>
            <img src="{{ $base64Signature }}" alt="Tanda Tangan">
            <div class="line-sign"></div>
            <p>(Penyedia Rental)</p>
        </div>
    </div>
</div>

</body>
</html>
