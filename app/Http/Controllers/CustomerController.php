<?php

namespace App\Http\Controllers;

use App\Repositories\Interface\CustomerRepositoryInterface;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function index()
    {
        $customers = $this->customerRepository->paginate(10); // Ambil 10 per halaman

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $this->customerRepository->create($validated);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function show($id)
    {
        $customer = $this->customerRepository->getById($id);
        if (! $customer) {
            return redirect()->route('customers.index')->with('error', 'Customer not found.');
        }

        return view('customers.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = $this->customerRepository->getById($id);
        if (! $customer) {
            return redirect()->route('customers.index')->with('error', 'Customer not found.');
        }

        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,'.$id,
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $customer = $this->customerRepository->update($id, $validated);
        if (! $customer) {
            return redirect()->route('customers.index')->with('error', 'Customer not found.');
        }

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy($id)
    {
        $deleted = $this->customerRepository->delete($id);
        if (! $deleted) {
            return redirect()->route('customers.index')->with('error', 'Customer not found.');
        }

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
