<?php

namespace App\Repositories;

use App\RawMaterialCategory;
use Illuminate\Http\Request;

class RawMaterialCategoryRepository extends BaseRepository
{
    private $rawMaterialCategory;
    public function __construct(RawMaterialCategory $rawMaterialCategory)
    {
        $this->rawMaterialCategory = $rawMaterialCategory;
    }

    public function search($parameters = null, $orders = null, $paginate = false)
    {
        $rawMaterialCategories = $this->rawMaterialCategory;
        $rawMaterialCategories = $this->setParameter($rawMaterialCategories, $parameters);
        $rawMaterialCategories = $this->setOrder($rawMaterialCategories, $orders);
        return $paginate == false ? $rawMaterialCategories->get() : $rawMaterialCategories->paginate($paginate);
    }

    public function find($value, $column = 'id')
    {
        return $this->rawMaterialCategory->where($column, '=', $value)->first();
    }

    public function save(Request $request)
    {
        return $this->rawMaterialCategory->create($request->all());
    }

    public function update($id, Request $request)
    {
        $rawMaterialCategory = $this->rawMaterialCategory->find($id);
        return $rawMaterialCategory->update($request->all());
    }

    public function delete($id)
    {
        return $this->rawMaterialCategory->find($id)->delete();
    }
}
