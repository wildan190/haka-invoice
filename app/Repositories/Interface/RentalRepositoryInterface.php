<?php

namespace App\Repositories\Interface;

use App\Models\Rental;

interface RentalRepositoryInterface
{
    public function getAll();

    public function getAllWithRelationsPaginated($perPage = 10, $search = null);

    public function getById(int $id): ?Rental;

    public function create(array $data): Rental;

    public function update(int $id, array $data): ?Rental;

    public function delete(int $id): bool;

    public function markAsPaid(int $id): ?Rental;
}
