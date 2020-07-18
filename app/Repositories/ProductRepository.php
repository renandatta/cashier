<?php

namespace App\Repositories;

use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;

class ProductRepository extends BaseRepository
{
    private $product;
    private $productCategory;
    public function __construct(Product $product, ProductCategory $productCategory)
    {
        $this->product = $product;
        $this->productCategory = $productCategory;
    }

    public function search($parameters = null, $orders = null, $paginate = false)
    {
        $products = $this->product;
        $products = $this->setParameter($products, $parameters);
        $products = $this->setOrder($products, $orders);
        return $paginate == false ? $products->get() : $products->paginate($paginate);
    }

    public function find($value, $column = 'id')
    {
        return $this->product->where($column, '=', $value)->first();
    }

    public function save(Request $request)
    {
        return $this->product->create($request->all());
    }

    public function update($id, Request $request)
    {
        $product = $this->product->find($id);
        return $product->update($request->all());
    }

    public function delete($id)
    {
        return $this->product->find($id)->delete();
    }

    public function getCategories()
    {
        return $this->productCategory->orderBy('name', 'asc')->get();
    }
}
