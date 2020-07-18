<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'product_id', 'raw_material_id', 'qty'
    ];
}
