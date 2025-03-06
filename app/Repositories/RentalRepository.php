<?php

namespace App\Repositories;

use App\Models\Rental;
use App\Repositories\Interface\RentalRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RentalRepository implements RentalRepositoryInterface
{
  public function getAll()
  {
    return Rental::with(['customer', 'mobil'])->paginate(10);
  }

  public function getAllWithRelationsPaginated($perPage = 10, $search = null)
  {
    $query = Rental::with(['customer', 'mobil']);

    if ($search) {
      $query->whereHas('customer', function ($q) use ($search) {
        $q->where('name', 'LIKE', "%$search%");
      })->orWhereHas('mobil', function ($q) use ($search) {
        $q->where('merk', 'LIKE', "%$search%")
          ->orWhere('type', 'LIKE', "%$search%");
      })->orWhere('status', 'LIKE', "%$search%");
    }

    return $query->paginate($perPage);
  }

  public function getById(int $id): ?Rental
  {
    return Rental::with(['customer', 'mobil'])->find($id);
  }

  public function create(array $data): Rental
  {
    $mobil = \App\Models\Mobil::findOrFail($data['mobil_id']);
    $harga_per_unit = $mobil->price;

    // Hitung total harga mobil
    $total = $data['duration'] * $harga_per_unit;

    // Hitung total harga layanan tambahan
    $total_service_price = 0;
    if (isset($data['services'])) {
      foreach ($data['services'] as $service) {
        $total_service_price += $service['service_price'];
      }
    }

    $total += $total_service_price;

    // Hitung PPN
    $ppn = $data['use_ppn'] ? $total * 0.11 : 0;
    $total_price = $total + $ppn;

    // Logika jika tidak menggunakan DP
    if ($data['use_dp'] == 0) {
      $dp_paid = $total_price;        // Semua harga masuk ke dp_paid
      $dp_remaining = 0;              // Sisa 0
      $status = 'lunas';              // Status lunas
    } else {
      $dp_paid = $data['dp_paid'] ?? 0;
      $dp_remaining = $total_price - $dp_paid;
      $status = $dp_remaining > 0 ? 'belum_lunas' : 'lunas';
    }

    // Simpan data rental
    $rental = Rental::create([
      'customer_id' => $data['customer_id'],
      'mobil_id' => $data['mobil_id'],
      'rental_type' => $data['rental_type'],
      'duration' => $data['duration'],
      'total_price' => $total_price,
      'use_dp' => $data['use_dp'],
      'dp_paid' => $dp_paid,
      'remaining_payment' => $dp_remaining,
      'ppn' => $ppn,
      'use_ppn' => $data['use_ppn'],
      'status' => $status,
    ]);

    // Simpan layanan tambahan
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

    $total_service_price = \array_sum(\array_column($data['services'] ?? [], 'service_price'));

    $total += $total_service_price;

    $ppn = $data['use_ppn'] ? $total * 0.11 : 0;
    $total_price = $total + $ppn;

    $dp_paid = $data['use_dp'] ? ($data['dp_paid'] ?? 0) : 0;

    if ($rental->status === 'lunas' && $total_service_price > 0) {
      $remaining_payment = $total_price - $rental->total_price;
    } else {
      $remaining_payment = $total_price - $dp_paid;
    }

    $status = $remaining_payment > 0 ? 'belum_lunas' : 'lunas';

    DB::transaction(function () use ($rental, $data, $dp_paid, $total_price, $remaining_payment, $ppn, $status) {
      // Update data rental
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
        'status' => $status,
      ]);

      $rental->services()->delete();

      if (isset($data['services'])) {
        foreach ($data['services'] as $service) {
          $rental->services()->create($service);
        }
      }
    });

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
