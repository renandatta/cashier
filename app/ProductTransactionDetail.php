<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed qty
 * @property mixed price
 */
class ProductTransactionDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'product_transaction_id', 'product_id', 'qty', 'price', 'status'
    ];

    public function product_transaction()
    {
        return $this->belongsTo(ProductTransaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getTotalAttribute()
    {
        return $this->qty * $this->price;
    }
}
