<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTransaction extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'customer_id', 'no_transaction', 'status', 'date', 'total', 'cash'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product_transaction_details()
    {
        return $this->hasMany(ProductTransactionDetail::class)
            ->with('product')
            ->orderBy('id', 'asc');
    }
}
