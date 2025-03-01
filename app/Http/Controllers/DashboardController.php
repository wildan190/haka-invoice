<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Mobil;
use App\Models\Rental;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data statistik
        $totalCustomers = Customer::count();
        $totalMobils = Mobil::count();
        $totalPendapatan = Rental::where('status', 'lunas')->sum('total_price');
        $nilaiBelumLunas = Rental::where('status', 'belum_lunas')->sum('remaining_payment');
        $nilaiSudahLunas = Rental::where('status', 'lunas')->sum('total_price');

        return view('dashboard.index', compact(
            'totalCustomers',
            'totalMobils',
            'totalPendapatan',
            'nilaiBelumLunas',
            'nilaiSudahLunas'
        ));
    }
}
