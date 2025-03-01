<?php

namespace App\Repositories;

use App\Models\Rental;
use App\Repositories\Interface\RentalRepositoryInterface;

class RentalRepository implements RentalRepositoryInterface
{
    public function getAll()
    {
        return Rental::with(['customer', 'mobil'])->paginate(10);
    }

    public function getById(int $id): ?Rental
    {
        return Rental::with(['customer', 'mobil'])->find($id);
    }

    public function create(array $data): Rental
    {
        $mobil = \App\Models\Mobil::findOrFail($data['mobil_id']);
        $harga_per_unit = $mobil->price;

        $total = $data['duration'] * $harga_per_unit;

        $total_service_price = 0;
        if (isset($data['services'])) {
            foreach ($data['services'] as $service) {
                $total_service_price += $service['service_price'];
            }
        }

        $total += $total_service_price;

        $ppn = $data['use_ppn'] ? $total * 0.11 : 0;
        $total_price = $total + $ppn;

        $dp_paid = $data['use_dp'] ? ($data['dp_paid'] ?? 0) : 0;
        $remaining_payment = $total_price - $dp_paid;

        $rental = Rental::create([
            'customer_id' => $data['customer_id'],
            'mobil_id' => $data['mobil_id'],
            'rental_type' => $data['rental_type'],
            'duration' => $data['duration'],
            'total_price' => $total_price,
            'use_dp' => $data['use_dp'],
            'dp_paid' => $dp_paid,
            'remaining_payment' => $remaining_payment,
            'ppn' => $ppn,
            'use_ppn' => $data['use_ppn'],
            'status' => $remaining_payment > 0 ? 'belum_lunas' : 'lunas',
        ]);

        if (isset($data['services'])) {
            foreach ($data['services'] as $service) {
                $rental->services()->create($service);
            }
        }

        return $rental;
    }

    public function update(int $id, array $data): ?Rental
    {
        $rental = Rental::find($id);
        if (! $rental) {
            return null;
        }

        $mobil = \App\Models\Mobil::findOrFail($data['mobil_id']);
        $harga_per_unit = $mobil->price;

        $total = $data['duration'] * $harga_per_unit;

        $total_service_price = 0;
        if (isset($data['services'])) {
            foreach ($data['services'] as $service) {
                $total_service_price += $service['service_price'];
            }
        }

        $total += $total_service_price;

        $ppn = $data['use_ppn'] ? $total * 0.11 : 0;
        $total_price = $total + $ppn;

        $dp_paid = $data['use_dp'] ? ($data['dp_paid'] ?? 0) : 0;
        $remaining_payment = $total_price - $dp_paid;

        $rental->update([
            'customer_id' => $data['customer_id'],
            'mobil_id' => $data['mobil_id'],
            'rental_type' => $data['rental_type'],
            'duration' => $data['duration'],
            'total_price' => $total_price,
            'use_dp' => $data['use_dp'],
            'dp_paid' => $dp_paid,
            'remaining_payment' => $remaining_payment,
            'ppn' => $ppn,
            'use_ppn' => $data['use_ppn'],
            'status' => $remaining_payment > 0 ? 'belum_lunas' : 'lunas',
        ]);

        $rental->services()->delete();

        if (isset($data['services'])) {
            foreach ($data['services'] as $service) {
                $rental->services()->create($service);
            }
        }

        return $rental;
    }

    public function delete(int $id): bool
    {
        $rental = Rental::with('invoice')->find($id);
    
        if ($rental) {
            $rental->invoice()->delete();
            return $rental->delete();
        }
    
        return false;
    }

    public function markAsPaid(int $id): ?Rental
    {
        $rental = Rental::find($id);
        if ($rental && $rental->status !== 'lunas') {
            $rental->update([
                'remaining_payment' => 0,
                'status' => 'lunas',
            ]);
        }

        return $rental;
    }
}
