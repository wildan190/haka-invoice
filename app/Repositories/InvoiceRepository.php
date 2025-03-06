<?php

namespace App\Repositories;

use App\Models\Invoice;
use App\Repositories\Interface\InvoiceRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function getAll(): LengthAwarePaginator
    {
        return Invoice::latest()->paginate(10);
    }

    public function search(?string $search): LengthAwarePaginator
    {
        $query = Invoice::query()->latest();

        if ($search) {
            $query->where('invoice_number', 'LIKE', "%$search%")
                ->orWhereHas('rental.customer', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%");
                })
                ->orWhereHas('rental.mobil', function ($q) use ($search) {
                    $q->where('type', 'LIKE', "%$search%");
                });
        }

        return $query->paginate(10);
    }

    public function getById(int $id): ?Invoice
    {
        return Invoice::find($id);
    }

    public function create(array $data): ?Invoice
    {
        if (Invoice::where('rental_id', $data['rental_id'])->exists()) {
            return null;
        }

        $data['invoice_number'] = Invoice::generateInvoiceNumber();

        return Invoice::create($data);
    }

    public function update(int $id, array $data): ?Invoice
    {
        $invoice = Invoice::find($id);
        if ($invoice) {
            $invoice->update($data);
        }

        return $invoice;
    }

    public function delete(int $id): bool
    {
        $invoice = Invoice::find($id);
        if ($invoice) {
            return $invoice->delete();
        }

        return false;
    }
}
