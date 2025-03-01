<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Interface\CustomerRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function getAll(): Collection
    {
        return Customer::all();
    }

    public function getAvailableCustomers()
    {
        return Customer::whereDoesntHave('rents')->get();
    }

    public function paginate(int $perPage): LengthAwarePaginator
    {
        return Customer::paginate($perPage);
    }

    public function getById(int $id): ?Customer
    {
        return Customer::find($id);
    }

    public function create(array $data): Customer
    {
        return Customer::create($data);
    }

    public function update(int $id, array $data): ?Customer
    {
        $customer = Customer::find($id);
        if ($customer) {
            $customer->update($data);
        }

        return $customer;
    }

    public function delete(int $id): bool
    {
        $customer = Customer::find($id);
        if ($customer) {
            return $customer->delete();
        }

        return false;
    }
}
