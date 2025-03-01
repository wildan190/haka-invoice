<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interface\RentalRepositoryInterface;
use App\Models\Customer;
use App\Models\Mobil;
use Illuminate\Support\Facades\Redirect;

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
}
