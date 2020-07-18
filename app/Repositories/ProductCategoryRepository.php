<?php

namespace App\Repositories;

use App\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryRepository extends BaseRepository
{
    private $productCategory;
    public function __construct(ProductCategory $productCategory)
    {
        $this->productCategory = $productCategory;
    }

    public function search($parameters = null, $orders = null, $paginate = false)
    {
        $productCategories = $this->productCategory;
        $productCategories = $this->setParameter($productCategories, $parameters);
        $productCategories = $this->setOrder($productCategories, $orders);
        return $paginate == false ? $productCategories->get() : $productCategories->paginate($paginate);
    }

    public function find($value, $column = 'id')
    {
        return $this->productCategory->where($column, '=', $value)->first();
    }

    public function save(Request $request)
    {
        return $this->productCategory->create($request->all());
    }

    public function update($id, Request $request)
    {
        $productCategory = $this->productCategory->find($id);
        return $productCategory->update($request->all());
    }

    public function delete($id)
    {
        return $this->productCategory->find($id)->delete();
    }
}
