<?php

namespace App\Repositories;

use App\ProductDetail;
use Illuminate\Http\Request;

class ProductDetailRepository extends BaseRepository
{
    private $productDetail;
    public function __construct(ProductDetail $productDetail)
    {
        $this->productDetail = $productDetail;
    }

    public function search($parameters = null, $orders = null, $paginate = false)
    {
        $productDetails = $this->productDetail;
        $productDetails = $this->setParameter($productDetails, $parameters);
        $productDetails = $this->setOrder($productDetails, $orders);
        return $paginate == false ? $productDetails->get() : $productDetails->paginate($paginate);
    }

    public function find($value, $column = 'id')
    {
        return $this->productDetail->where($column, '=', $value)->first();
    }

    public function save(Request $request)
    {
        return $this->productDetail->create($request->all());
    }

    public function update($id, Request $request)
    {
        $productDetail = $this->productDetail->find($id);
        return $productDetail->update($request->all());
    }

    public function delete($id)
    {
        return $this->productDetail->find($id)->delete();
    }
}
