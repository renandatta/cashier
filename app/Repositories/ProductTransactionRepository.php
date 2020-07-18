<?php

namespace App\Repositories;

use App\ProductTransaction;
use App\Product;
use App\ProductTransactionDetail;
use Illuminate\Http\Request;

class ProductTransactionRepository extends BaseRepository
{
    private $productTransaction;
    private $productTransactionDetail;
    private $product;
    public function __construct(ProductTransaction $productTransaction,
                                ProductTransactionDetail $productTransactionDetail,
                                Product $product)
    {
        $this->productTransaction = $productTransaction;
        $this->productTransactionDetail = $productTransactionDetail;
        $this->product = $product;
    }

    public function search($parameters = null, $orders = null, $paginate = false)
    {
        $productTransactions = $this->productTransaction->with('user');
        $productTransactions = $this->setParameter($productTransactions, $parameters);
        $productTransactions = $this->setOrder($productTransactions, $orders);
        return $paginate == false ? $productTransactions->get() : $productTransactions->paginate($paginate);
    }

    public function find($value, $column = 'id')
    {
        return $this->productTransaction->where($column, '=', $value)->first();
    }

    public function save(Request $request)
    {
        $request->merge(['status' => 'Proses']);
        return $this->productTransaction->create($request->all());
    }

    public function update($id, Request $request)
    {
        $productTransaction = $this->productTransaction->find($id);
        $productTransaction->update($request->all());
        return $productTransaction;
    }

    public function delete($id)
    {
        return $this->productTransaction->find($id)->delete();
    }

    public function save_detail(Request $request)
    {
        $request->merge(['status' => 'Proses']);
        $detail = $this->productTransactionDetail->create($request->all());
        $product = $this->product->find($detail->product_id);
        $product->stock -= $detail->qty;
        $product->save();
        $detail->product = $product;
        $detail->total = $detail->total;
        return $detail;
    }

    public function delete_detail($id)
    {
        $detail = $this->productTransactionDetail->find($id);
        $detail->total = $detail->total;
        $product = $this->product->find($detail->product_id);
        $product->stock += $detail->qty;
        $product->save();
        $detail->delete();
        return $detail;
    }
}
