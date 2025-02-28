@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1 class="my-4">Dashboard</h1>

    <div class="row">
        <!-- Total Customers -->
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Customer</h5>
                    <p class="card-text display-4">{{ $totalCustomers }}</p>
                </div>
            </div>
        </div>

        <!-- Total Mobil -->
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Mobil</h5>
                    <p class="card-text display-4">{{ $totalMobils }}</p>
                </div>
            </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="col-md-4">
            <div class="card text-white bg-dark mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Pendapatan</h5>
                    <p class="card-text display-4">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Statistik Pembayaran</h5>
            <canvas id="rentalChart"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById('rentalChart').getContext('2d');
        var rentalChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Belum Lunas', 'Sudah Lunas'],
                datasets: [{
                    label: 'Jumlah (Rp)',
                    data: [{{ $nilaiBelumLunas }}, {{ $nilaiSudahLunas }}],
                    backgroundColor: ['#dc3545', '#28a745'],
                    borderWidth: 1
                }]
            }
        });
    });
</script>
@endsection
