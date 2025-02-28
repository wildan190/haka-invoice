<?php

namespace App\Repositories;

use App\Models\Mobil;
use App\Repositories\Interface\MobilRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class MobilRepository implements MobilRepositoryInterface
{
    public function getAll(): Collection
    {
        return Mobil::all();
    }

    public function paginate(int $perPage): LengthAwarePaginator
    {
        return Mobil::paginate($perPage);
    }

    public function getById(int $id): ?Mobil
    {
        return Mobil::find($id);
    }

    public function create(array $data): Mobil
    {
        return Mobil::create($data);
    }

    public function update(int $id, array $data): ?Mobil
    {
        $mobil = Mobil::find($id);
        if ($mobil) {
            $mobil->update($data);
        }
        return $mobil;
    }

    public function delete(int $id): bool
    {
        $mobil = Mobil::find($id);
        if ($mobil) {
            return $mobil->delete();
        }
        return false;
    }
}
