<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'product_category_id', 'code', 'name', 'tag', 'description', 'price', 'unit'
    ];

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
