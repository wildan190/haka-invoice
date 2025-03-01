<?php

namespace App\Repositories\Interface;

use App\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface CustomerRepositoryInterface
{
    public function getAll(): Collection;

    public function paginate(int $perPage): LengthAwarePaginator; // Tambahkan ini

    public function getAvailableCustomers();

    public function getById(int $id): ?Customer;

    public function create(array $data): Customer;

    public function update(int $id, array $data): ?Customer;

    public function delete(int $id): bool;
}
