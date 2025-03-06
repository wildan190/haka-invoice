<?php

namespace App\Repositories\Interface;

use App\Models\Invoice;
use Illuminate\Pagination\LengthAwarePaginator;

interface InvoiceRepositoryInterface
{
    public function getAll(): LengthAwarePaginator;

    public function search(?string $search): LengthAwarePaginator;

    public function getById(int $id): ?Invoice;

    public function create(array $data): ?Invoice;

    public function update(int $id, array $data): ?Invoice;

    public function delete(int $id): bool;
}
