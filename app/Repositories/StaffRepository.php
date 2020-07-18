<?php

namespace App\Repositories;

use App\Staff;
use Illuminate\Http\Request;

class StaffRepository extends BaseRepository
{
    private $staff;
    public function __construct(Staff $staff)
    {
        $this->staff = $staff;
    }

    public function search($parameters = null, $orders = null, $paginate = false)
    {
        $staffs = $this->staff;
        $staffs = $this->setParameter($staffs, $parameters);
        $staffs = $this->setOrder($staffs, $orders);
        return $paginate == false ? $staffs->get() : $staffs->paginate($paginate);
    }

    public function find($value, $column = 'id')
    {
        return $this->staff->where($column, '=', $value)->first();
    }

    public function save(Request $request)
    {
        return $this->staff->create($request->all());
    }

    public function update($id, Request $request)
    {
        $staff = $this->staff->find($id);
        return $staff->update($request->all());
    }

    public function delete($id)
    {
        return $this->staff->find($id)->delete();
    }
}
