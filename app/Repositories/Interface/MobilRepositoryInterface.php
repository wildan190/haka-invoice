<?php

namespace App\Repositories\Interface;

use App\Models\Mobil;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface MobilRepositoryInterface
{
    public function getAll(): Collection;

    public function paginate(int $perPage): LengthAwarePaginator;

    public function getById(int $id): ?Mobil;

    public function create(array $data): Mobil;

    public function update(int $id, array $data): ?Mobil;

    public function delete(int $id): bool;
}
