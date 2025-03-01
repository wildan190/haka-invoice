<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Mobil;
use App\Repositories\Interface\RentalRepositoryInterface;
use Illuminate\Http\Request;
use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;

class RentalController extends Controller
{
    protected $rentalRepository;

    public function __construct(RentalRepositoryInterface $rentalRepository)
    {
        $this->rentalRepository = $rentalRepository;
    }

    public function index()
    {
        $rentals = $this->rentalRepository->getAll();

        return view('rentals.index', compact('rentals'));
    }

    public function create()
    {
        $customers = Customer::doesntHave('rentals')->get();
        $mobils = Mobil::all();

        return view('rentals.create', compact('customers', 'mobils'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'mobil_id' => 'required|exists:mobils,id',
            'rental_type' => 'required|in:hari,bulan',
            'duration' => 'required|integer|min:1',
            'use_dp' => 'required|boolean',
            'use_ppn' => 'required|boolean',
            'dp_paid' => 'nullable|numeric|min:0',
            'services.*.service_name' => 'required|string|max:255',
            'services.*.service_price' => 'required|numeric|min:0',
        ]);

        $this->rentalRepository->create($request->all());

        return redirect()->route('rentals.index')->with('success', 'Rental berhasil dibuat.');
    }

    public function show($id)
    {
        $rental = $this->rentalRepository->getById($id);

        return view('rentals.show', compact('rental'));
    }

    public function edit($id)
    {
        $rental = $this->rentalRepository->getById($id);
        $customers = Customer::where('id', $rental->customer_id)->get();
        $mobils = Mobil::all();

        return view('rentals.edit', compact('rental', 'customers', 'mobils'));
    }

    public function update(Request $request, $id)
    {
        $this->rentalRepository->update($id, $request->all());

        return redirect()->route('rentals.index')->with('success', 'Rental berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->rentalRepository->delete($id);

        return redirect()->route('rentals.index')->with('success', 'Rental berhasil dihapus.');
    }

    public function markAsPaid($id)
    {
        $this->rentalRepository->markAsPaid($id);

        return redirect()->route('rentals.index')->with('success', 'Rental telah dilunasi.');
    }

    public function printReceipt($id)
    {
        $rental = $this->rentalRepository->getById($id);
        if (!$rental) {
            return redirect()->route('rentals.index')->with('error', 'Rental tidak ditemukan.');
        }

        // Ambil tanda tangan
        $signaturePath = public_path('assets/img/ttd/ttd.jpeg');
        $base64Signature = '';
        if (file_exists($signaturePath)) {
            $signatureData = file_get_contents($signaturePath);
            $base64Signature = 'data:image/jpeg;base64,' . base64_encode($signatureData);
        }

        // Buat view untuk PDF
        $pdfView = View::make('rentals.receipt', compact('rental', 'base64Signature'))->render();

        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($pdfView);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream("kwitansi_rental_{$rental->id}.pdf");
    }
}
