<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Repositories\Interface\InvoiceRepositoryInterface;
use App\Repositories\Interface\RentalRepositoryInterface;
use Illuminate\Http\Request;
use PDF;

class InvoiceController extends Controller
{
  protected $invoiceRepository;

  protected $rentalRepository;

  public function __construct(InvoiceRepositoryInterface $invoiceRepository, RentalRepositoryInterface $rentalRepository)
  {
    $this->invoiceRepository = $invoiceRepository;
    $this->rentalRepository = $rentalRepository;
  }

  public function index(Request $request)
  {
    $search = $request->input('search');
    $invoices = $this->invoiceRepository->search($search);

    return view('invoices.index', compact('invoices'));
  }

  public function create()
  {
    $rentals = $this->rentalRepository->getAll();

    return view('invoices.create', compact('rentals'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'rental_id' => 'required|exists:rentals,id|unique:invoices,rental_id',
      'invoice_date' => 'required|date',
    ]);

    $data = $request->only(['rental_id', 'invoice_date']);

    $invoice = $this->invoiceRepository->create($data);

    if (! $invoice) {
      return redirect()->route('invoices.create')->with('error', 'Invoice untuk rental ini sudah ada!');
    }

    return redirect()->route('invoices.index')->with('success', 'Invoice berhasil dibuat!');
  }

  public function show($id)
  {
    $invoice = $this->invoiceRepository->getById($id);
    if (! $invoice) {
      return redirect()->route('invoices.index')->with('error', 'Invoice tidak ditemukan.');
    }

    return view('invoices.show', compact('invoice'));
  }

  public function edit($id)
  {
    $invoice = $this->invoiceRepository->getById($id);
    if (! $invoice) {
      return redirect()->route('invoices.index')->with('error', 'Invoice tidak ditemukan.');
    }

    return view('invoices.edit', compact('invoice'));
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'invoice_date' => 'required|date',
    ]);

    $data = $request->only(['invoice_date']);
    $invoice = $this->invoiceRepository->update($id, $data);

    if (! $invoice) {
      return redirect()->route('invoices.index')->with('error', 'Gagal memperbarui invoice.');
    }

    return redirect()->route('invoices.index')->with('success', 'Invoice berhasil diperbarui!');
  }

  public function destroy($id)
  {
    $deleted = $this->invoiceRepository->delete($id);

    if (! $deleted) {
      return redirect()->route('invoices.index')->with('error', 'Gagal menghapus invoice.');
    }

    return redirect()->route('invoices.index')->with('success', 'Invoice berhasil dihapus!');
  }

  public function generatePDF($id)
  {
    $invoice = Invoice::with('rental.customer', 'rental.mobil')->findOrFail($id);

    $dpPaid = $invoice->rental->dp_paid ?? 0;

    $remainingPayment = $invoice->rental->total_price - $dpPaid;

    $invoice->rental->remaining_payment = max(0, $remainingPayment);

    $safeInvoiceNumber = str_replace('/', '-', $invoice->invoice_number);

    $pdf = PDF::loadView('invoices.pdf', compact('invoice'));

    return $pdf->download("Invoice_{$safeInvoiceNumber}.pdf");
  }
}
