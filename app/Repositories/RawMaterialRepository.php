<?php

namespace App\Repositories;

use App\RawMaterial;
use App\RawMaterialCategory;
use Illuminate\Http\Request;

class RawMaterialRepository extends BaseRepository
{
    private $rawMaterial;
    private $rawMaterialCategory;
    public function __construct(RawMaterial $rawMaterial, RawMaterialCategory $rawMaterialCategory)
    {
        $this->rawMaterial = $rawMaterial;
        $this->rawMaterialCategory = $rawMaterialCategory;
    }

    public function search($parameters = null, $orders = null, $paginate = false)
    {
        $rawMaterials = $this->rawMaterial->with('raw_material_category');
        $rawMaterials = $this->setParameter($rawMaterials, $parameters);
        $rawMaterials = $this->setOrder($rawMaterials, $orders);
        return $paginate == false ? $rawMaterials->get() : $rawMaterials->paginate($paginate);
    }

    public function find($value, $column = 'id')
    {
        return $this->rawMaterial->where($column, '=', $value)->first();
    }

    public function save(Request $request)
    {
        return $this->rawMaterial->create($request->all());
    }

    public function update($id, Request $request)
    {
        $rawMaterial = $this->rawMaterial->find($id);
        return $rawMaterial->update($request->all());
    }

    public function delete($id)
    {
        return $this->rawMaterial->find($id)->delete();
    }

    public function getCategories()
    {
        return $this->rawMaterialCategory->orderBy('name', 'asc')->get();
    }

}
