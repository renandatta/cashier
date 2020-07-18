<?php

namespace App\Repositories;

use App\Customer;
use Illuminate\Http\Request;

class CustomerRepository extends BaseRepository
{
    private $customer;
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function search($parameters = null, $orders = null, $paginate = false)
    {
        $customers = $this->customer;
        $customers = $this->setParameter($customers, $parameters);
        $customers = $this->setOrder($customers, $orders);
        return $paginate == false ? $customers->get() : $customers->paginate($paginate);
    }

    public function find($value, $column = 'id')
    {
        return $this->customer->where($column, '=', $value)->first();
    }

    public function save(Request $request)
    {
        return $this->customer->create($request->all());
    }

    public function update($id, Request $request)
    {
        $customer = $this->customer->find($id);
        return $customer->update($request->all());
    }

    public function delete($id)
    {
        return $this->customer->find($id)->delete();
    }
}
